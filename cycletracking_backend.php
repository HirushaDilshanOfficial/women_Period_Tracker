<?php
// Prevent direct access
if (!defined('ALLOWED_ACCESS')) {
    define('ALLOWED_ACCESS', true);
}

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit();
}

// Function to get cycle statistics
function getCycleStatistics($user_id) {
    try {
        $pdo = getDBConnection();
        
        // Get average cycle length
        $stmt = $pdo->prepare("
            SELECT 
                AVG(DATEDIFF(end_date, start_date)) as avg_period_length,
                AVG(cycle_length) as avg_cycle_length
            FROM cycle_entries 
            WHERE user_id = ? 
            AND start_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        ");
        $stmt->execute([$user_id]);
        $stats = $stmt->fetch();

        // Get latest cycle entry to calculate next period
        $stmt = $pdo->prepare("
            SELECT start_date, cycle_length 
            FROM cycle_entries 
            WHERE user_id = ? 
            ORDER BY start_date DESC 
            LIMIT 1
        ");
        $stmt->execute([$user_id]);
        $lastCycle = $stmt->fetch();

        $stats['next_period_in'] = calculateNextPeriod($lastCycle);
        $stats['current_phase'] = calculateCyclePhase($lastCycle);
        
        return $stats;
    } catch (PDOException $e) {
        error_log("Error getting cycle statistics: " . $e->getMessage());
        return null;
    }
}

// Function to calculate next period
function calculateNextPeriod($lastCycle) {
    if (!$lastCycle) return 'N/A';

    $lastStart = new DateTime($lastCycle['start_date']);
    $cycleLength = $lastCycle['cycle_length'] ?? 28;
    $nextPeriod = $lastStart->modify("+{$cycleLength} days");
    $today = new DateTime();
    
    $daysUntil = $today->diff($nextPeriod)->days;
    
    if ($daysUntil <= 0) {
        return 'Due now';
    }
    return $daysUntil . ' days';
}

// Function to calculate cycle phase
function calculateCyclePhase($lastCycle) {
    if (!$lastCycle) return 'Not Available';

    $lastStart = new DateTime($lastCycle['start_date']);
    $today = new DateTime();
    $daysSinceStart = $today->diff($lastStart)->days;
    $cycleLength = $lastCycle['cycle_length'] ?? 28;

    // Define cycle phases
    if ($daysSinceStart <= 5) {
        return 'Menstrual';
    } elseif ($daysSinceStart <= 10) {
        return 'Follicular';
    } elseif ($daysSinceStart <= 14) {
        return 'Ovulation';
    } else {
        return 'Luteal';
    }
}

// Function to save cycle entry
function saveCycleEntry($user_id, $data) {
    try {
        $pdo = getDBConnection();
        
        $stmt = $pdo->prepare("
            INSERT INTO cycle_entries (
                user_id, start_date, end_date, flow_intensity, 
                symptoms, moods, notes, cycle_length
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // Calculate cycle length based on previous entry
        $prevStmt = $pdo->prepare("
            SELECT start_date FROM cycle_entries 
            WHERE user_id = ? 
            ORDER BY start_date DESC 
            LIMIT 1
        ");
        $prevStmt->execute([$user_id]);
        $prevCycle = $prevStmt->fetch();

        $cycleLength = null;
        if ($prevCycle) {
            $prevStart = new DateTime($prevCycle['start_date']);
            $currentStart = new DateTime($data['startDate']);
            $cycleLength = $prevStart->diff($currentStart)->days;
        }

        $symptoms = json_encode($data['symptoms'] ?? []);
        $moods = json_encode($data['moods'] ?? []);

        $stmt->execute([
            $user_id,
            $data['startDate'],
            $data['endDate'],
            $data['flowIntensity'],
            $symptoms,
            $moods,
            $data['notes'],
            $cycleLength
        ]);

        // Get updated statistics
        $stats = getCycleStatistics($user_id);
        
        return [
            'success' => true,
            'stats' => $stats,
            'message' => 'Entry saved successfully'
        ];
    } catch (PDOException $e) {
        error_log("Error saving cycle entry: " . $e->getMessage());
        return [
            'success' => false,
            'error' => 'Failed to save entry'
        ];
    }
}

// Function to get symptom trends data
function getSymptomTrends($user_id) {
    try {
        $pdo = getDBConnection();
        
        // Fetch symptom data for the last 28 days
        $stmt = $pdo->prepare("
            SELECT 
                DATE(start_date) as date,
                symptoms
            FROM cycle_entries 
            WHERE user_id = ? 
            AND start_date >= DATE_SUB(NOW(), INTERVAL 28 DAY)
            ORDER BY start_date ASC
        ");
        $stmt->execute([$user_id]);
        $symptomData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process symptom data
        $chartData = [];
        foreach ($symptomData as $entry) {
            $symptoms = json_decode($entry['symptoms'], true);
            if (is_array($symptoms)) {
                foreach ($symptoms as $symptom) {
                    if (!isset($chartData[$symptom])) {
                        $chartData[$symptom] = array_fill(0, 28, 0); // Initialize with 28 days
                    }
                    $day = (new DateTime($entry['date']))->diff(new DateTime())->days;
                    if ($day < 28) {
                        $chartData[$symptom][$day]++;
                    }
                }
            }
        }

        return $chartData;
    } catch (PDOException $e) {
        error_log("Error fetching symptom trends: " . $e->getMessage());
        return [];
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'save_entry':
                $result = saveCycleEntry($user_id, $input);
                echo json_encode($result);
                break;
                
            case 'get_stats':
                $stats = getCycleStatistics($user_id);
                echo json_encode($stats);
                break;
        }
        exit();
    }
}

// Get initial data for page load
$stats = getCycleStatistics($user_id);
$chartData = getSymptomTrends($user_id); // Fetch symptom trends data

// Variables for the template
$avgCycleLength = round($stats['avg_cycle_length'] ?? 28);
$avgPeriodLength = round($stats['avg_period_length'] ?? 5);
$nextPeriodIn = $stats['next_period_in'] ?? 'N/A';
$currentPhase = $stats['current_phase'] ?? 'Not Available';
$cycleDay = isset($stats['cycle_day']) ? $stats['cycle_day'] : 1;
?>