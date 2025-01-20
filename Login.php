<?php
    define('ALLOWED_ACCESS', true);

    // Include configuration file
    require_once 'config.php';
    
    // Include login handler
    require_once 'login_Handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl relative">
        <!-- Back button -->
        <a href="index.php" class="absolute left-8 top-8 flex items-center text-pink-600 hover:text-pink-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Home
        </a>

        <div class="text-center mb-8 mt-8">
            <i class="fas fa-heartbeat text-pink-600 text-4xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900">Welcome to FemCare</h1>
            <p class="text-gray-600 mt-2">Please sign in to continue</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <!-- Add CSRF token here -->
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            
            <div>
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
            </div>
            
            <div>
                <label class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-pink-600">
                    <span class="ml-2 text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-pink-600 hover:text-pink-700">Forgot password?</a>
            </div>

            <button type="submit" name="login"
                class="w-full py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition-all">
                Sign In
            </button>

            <p class="text-center text-gray-600">
                Don't have an account? 
                <a href="register.php" class="text-pink-600 hover:text-pink-700">Sign up</a>
            </p>
        </form>
    </div>
</body>
</html>