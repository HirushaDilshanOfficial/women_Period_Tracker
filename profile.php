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

// Fetch user profile data from the database
$profile = [];
$trackedCycles = 0;
$nextPeriodDate = 'N/A';
try {
    $pdo = getDBConnection();

    // Fetch user profile data
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, date_of_birth, cycle_length, period_length FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch cycle history count
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM cycle_entries WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $trackedCycles = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Calculate next period date (example logic)
    if (!empty($profile['cycle_length'])) {
        $lastCycleEndDate = '2024-01-01'; // Replace with actual logic to fetch the last cycle end date
        $nextPeriodDate = date('M d, Y', strtotime($lastCycleEndDate . ' + ' . $profile['cycle_length'] . ' days'));
    }
} catch (PDOException $e) {
    error_log("Error fetching profile data: " . $e->getMessage());
    $profile = []; // Ensure profile is an empty array if there's an error
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $birth_date = sanitizeInput($_POST['birth_date']);
    $cycle_length = intval($_POST['cycle_length']);
    $period_length = intval($_POST['period_length']);

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($birth_date)) {
        setFlashMessage('error', 'All fields are required.');
        header('Location: profile.php');
        exit();
    }

    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, date_of_birth = :birth_date, cycle_length = :cycle_length, period_length = :period_length WHERE id = :user_id");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'birth_date' => $birth_date,
            'cycle_length' => $cycle_length,
            'period_length' => $period_length,
            'user_id' => $_SESSION['user_id']
        ]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            setFlashMessage('success', 'Profile updated successfully!');
        } else {
            setFlashMessage('error', 'No changes were made to your profile.');
        }

        // Redirect to the profile page
        header('Location: profile.php');
        exit();
    } catch (PDOException $e) {
        error_log("Error updating profile: " . $e->getMessage());
        setFlashMessage('error', 'Failed to update profile. Please try again.');
        header('Location: profile.php');
        exit();
    }
}

// Fetch cycle history from the database
$cycles = [];
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT id, start_date, end_date, cycle_length, symptoms FROM cycle_entries WHERE user_id = :user_id ORDER BY start_date DESC LIMIT 3");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $cycles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching cycle history: " . $e->getMessage());
    $cycles = [];
}

// Calculate profile completion percentage
$profileCompletion = 0;
if (!empty($profile)) {
    $totalFields = 6; // first_name, last_name, email, date_of_birth, cycle_length, period_length
    $filledFields = 0;
    foreach ($profile as $value) {
        if (!empty($value)) {
            $filledFields++;
        }
    }
    $profileCompletion = round(($filledFields / $totalFields) * 100);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #ff80b5, #9089fc, #ff80b5, #9089fc);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
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
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-2 space-y-4">
                <a href="cycletracking.php" class="block text-gray-600 hover:text-pink-600">
                    <i class="fas fa-calendar-days mr-2"></i>Cycle Tracking
                </a>
                <a href="notification.php" class="block text-gray-600 hover:text-pink-600">
                    <i class="fas fa-bell mr-2"></i>Notifications
                    <span class="bg-pink-600 text-white text-xs px-2 py-1 rounded-full ml-2">3</span>
                </a>
                <a href="symptom.php" class="block text-gray-600 hover:text-pink-600">
                    <i class="fas fa-notes-medical mr-2"></i>Symptoms
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Next Period</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($nextPeriodDate); ?></h3>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-lg">
                        <i class="fas fa-calendar text-pink-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Cycle Length</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($profile['cycle_length'] ?? '28'); ?> Days</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Period Length</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($profile['period_length'] ?? '5'); ?> Days</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-hourglass text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Tracked Cycles</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($trackedCycles); ?></h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24">
                    <div class="text-center">
                        <div class="relative inline-block group">
                            <img src="/api/placeholder/120/120" alt="Profile" class="rounded-full mb-4 border-4 border-pink-200 p-1">
                            <button class="absolute bottom-0 right-0 bg-pink-600 text-white p-2 rounded-full hover:bg-pink-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Unable User Name'); ?></h2>
                        <p class="text-gray-600">Member since <?php echo date('F Y'); ?></p>
                        
                        <!-- Completion Status -->
                        <div class="mt-6 bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 mb-2">Profile Completion</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-pink-600 to-purple-600 h-2.5 rounded-full" style="width: <?php echo $profileCompletion; ?>%"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2"><?php echo $profileCompletion; ?>% Complete</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <a href="cycletracking.php" class="flex items-center justify-between p-4 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-calendar-days text-pink-600"></i>
                                <span class="text-pink-600">Cycle Tracking</span>
                            </div>
                            <i class="fas fa-chevron-right text-pink-600"></i>
                        </a>
                        <a href="notification.php" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-bell text-purple-600"></i>
                                <span class="text-purple-600">Notifications</span>
                            </div>
                            <i class="fas fa-chevron-right text-purple-600"></i>
                        </a>
                        <a href="symptom.php" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-notes-medical text-blue-600"></i>
                                <span class="text-blue-600">Symptoms</span>
                            </div>
                            <i class="fas fa-chevron-right text-blue-600"></i>
                        </a>
                        <button id="logout-btn" class="w-full flex items-center justify-center space-x-2 p-4 bg-red-50 rounded-lg hover:bg-red-100 text-red-600 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Settings -->
            <div class="md:col-span-2 space-y-6">
                <!-- Profile Form -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Profile Settings</h3>
                        <div class="relative">
                            <button id="save-profile" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:opacity-90 transition-all flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </div>
                    <form id="profile-form" class="space-y-6" method="POST" action="profile.php">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2">First Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>" 
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Last Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Birth Date</label>
                            <div class="relative">
                                <i class="fas fa-birthday-cake absolute left-3 top-3 text-gray-400"></i>
                                <input type="date" name="birth_date" value="<?php echo htmlspecialchars($profile['date_of_birth'] ?? ''); ?>"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2">Average Cycle Length</label>
                                <div class="relative">
                                    <i class="fas fa-calendar absolute left-3 top-3 text-gray-400"></i>
                                    <input type="number" name="cycle_length" value="<?php echo htmlspecialchars($profile['cycle_length'] ?? '28'); ?>"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" min="20" max="45" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Average Period Length</label>
                                <div class="relative">
                                    <i class="fas fa-clock absolute left-3 top-3 text-gray-400"></i>
                                    <input type="number" name="period_length" value="<?php echo htmlspecialchars($profile['period_length'] ?? '5'); ?>"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                        min="2" max="10" required>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Preferences -->
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Notification Preferences</h4>
                            <div class="space-y-4">
                                <label class="flex items-center space-x-3">
                                    <div class="relative">
                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-pink-600 rounded border-gray-300 focus:ring-pink-500" checked>
                                    </div>
                                    <span class="text-gray-700">Period Reminders (3 days before)</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-pink-600 rounded border-gray-300 focus:ring-pink-500" checked>
                                    <span class="text-gray-700">Ovulation Alerts</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <span class="text-gray-700">Medication Reminders</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Cycle History -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Recent Cycle History</h3>
                        <button class="text-pink-600 hover:text-pink-700 flex items-center space-x-2">
                            <span>View All</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-4 text-gray-600 font-semibold">Start Date</th>
                                    <th class="pb-4 text-gray-600 font-semibold">End Date</th>
                                    <th class="pb-4 text-gray-600 font-semibold">Length</th>
                                    <th class="pb-4 text-gray-600 font-semibold">Symptoms</th>
                                    <th class="pb-4 text-gray-600 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cycles as $cycle): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4">
                                        <span class="font-medium"><?php echo date('M d, Y', strtotime($cycle['start_date'])); ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="font-medium"><?php echo date('M d, Y', strtotime($cycle['end_date'])); ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="font-medium"><?php echo $cycle['cycle_length']; ?> days</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex gap-2">
                                            <?php
                                            // Decode symptoms and ensure it's an array
                                            $symptoms = json_decode($cycle['symptoms'], true) ?? [];
                                            if (is_array($symptoms)) {
                                                foreach ($symptoms as $symptom): ?>
                                                    <span class="px-2 py-1 bg-pink-100 text-pink-700 rounded-full text-sm">
                                                        <?php echo htmlspecialchars($symptom); ?>
                                                    </span>
                                                <?php endforeach;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex space-x-2">
                                            <a href="edit_cycle.php?id=<?php echo $cycle['id']; ?>" class="text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_cycle.php?id=<?php echo $cycle['id']; ?>" class="text-red-600 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this cycle?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform translate-y-full opacity-0 transition-all duration-300">
        <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span>Changes saved successfully!</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Profile form submission
            const profileForm = document.getElementById('profile-form');
            const saveButton = document.getElementById('save-profile');
            const toast = document.getElementById('toast');

            saveButton.addEventListener('click', async function(e) {
                e.preventDefault();
                
                // Show loading state
                saveButton.disabled = true;
                saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

                try {
                    // Submit the form
                    profileForm.submit();
                } catch (error) {
                    console.error('Error saving profile:', error);
                } finally {
                    // Reset button state
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                }
            });

            // Logout confirmation
            const logoutBtn = document.getElementById('logout-btn');
            logoutBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = 'logout.php';
                }
            });

            // Form validation
            profileForm.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    validateInput(this);
                });
            });

            function validateInput(input) {
                const value = input.value.trim();
                
                switch(input.name) {
                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                        break;
                    case 'cycle_length':
                        const cycleLength = parseInt(value);
                        if (cycleLength < 20 || cycleLength > 45) {
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                        break;
                    case 'period_length':
                        const periodLength = parseInt(value);
                        if (periodLength < 2 || periodLength > 10) {
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                        break;
                    default:
                        if (!value) {
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                }
            }
        });
    </script>
</body>
</html>