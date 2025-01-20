<?php
define('ALLOWED_ACCESS', true); // Allow access to config.php
require_once 'config.php';
require_once 'login_Handler.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Check if cycle ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setFlashMessage('error', 'Invalid cycle ID.');
    header('Location: profile.php');
    exit();
}

$cycleId = intval($_GET['id']);

// Fetch the cycle data from the database
$cycle = [];
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT id, start_date, end_date, cycle_length, symptoms FROM cycle_entries WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $cycleId, 'user_id' => $_SESSION['user_id']]);
    $cycle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cycle) {
        setFlashMessage('error', 'Cycle not found or you do not have permission to edit it.');
        header('Location: profile.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Error fetching cycle data: " . $e->getMessage());
    setFlashMessage('error', 'Failed to fetch cycle data. Please try again.');
    header('Location: profile.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = sanitizeInput($_POST['start_date']);
    $end_date = sanitizeInput($_POST['end_date']);
    $cycle_length = intval($_POST['cycle_length']);
    $symptoms = json_encode($_POST['symptoms'] ?? []); // Convert symptoms array to JSON

    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE cycle_entries SET start_date = :start_date, end_date = :end_date, cycle_length = :cycle_length, symptoms = :symptoms WHERE id = :id AND user_id = :user_id");
        $stmt->execute([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cycle_length' => $cycle_length,
            'symptoms' => $symptoms,
            'id' => $cycleId,
            'user_id' => $_SESSION['user_id']
        ]);

        // Set a success message
        setFlashMessage('success', 'Cycle updated successfully!');
        header('Location: profile.php');
        exit();
    } catch (PDOException $e) {
        error_log("Error updating cycle: " . $e->getMessage());
        setFlashMessage('error', 'Failed to update cycle. Please try again.');
    }
}

// Decode symptoms JSON and ensure it's an array
$symptomsArray = json_decode($cycle['symptoms'], true) ?? [];
$symptomsString = is_array($symptomsArray) ? implode(', ', $symptomsArray) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare - Edit Cycle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <!-- Navigation -->
    <nav class="glass-effect sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-2">
                    <div class="gradient-bg p-2 rounded-lg">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 text-transparent bg-clip-text">FemCare</span>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="cycletracking.php" class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors">
                        <i class="fas fa-calendar-days"></i>
                        <span>Cycle Tracking</span>
                    </a>
                    <a href="notification.php" class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <span class="bg-pink-600 text-white text-xs px-2 py-1 rounded-full">3</span>
                    </a>
                    <a href="symptom.php" class="flex items-center space-x-2 text-gray-600 hover:text-pink-600 transition-colors">
                        <i class="fas fa-notes-medical"></i>
                        <span>Symptoms</span>
                    </a>
                </div>
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Cycle</h2>
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($cycle['start_date']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($cycle['end_date']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Cycle Length (Days)</label>
                    <input type="number" name="cycle_length" value="<?php echo htmlspecialchars($cycle['cycle_length']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" min="20" max="45" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Symptoms</label>
                    <textarea name="symptoms" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"><?php echo htmlspecialchars($symptomsString); ?></textarea>
                </div>
                <div>
                    <button type="submit" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:opacity-90 transition-all">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>