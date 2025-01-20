<?php
define('ALLOWED_ACCESS', true);
session_start();
require_once 'signup_Handler.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen p-4">
    <!-- Back to Home Button -->
    <a href="index.php" class="fixed top-4 left-4 bg-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all">
        <i class="fas fa-arrow-left text-pink-600"></i>
    </a>

    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-600 to-purple-600 p-8 text-white text-center">
                <i class="fas fa-heartbeat text-5xl mb-4"></i>
                <h1 class="text-3xl font-bold">Join FemCare</h1>
                <p class="mt-2 text-pink-100">Start your journey to better health</p>
            </div>

            <div class="p-8">
                <!-- Signup Form -->
                <form method="POST" class="space-y-6" id="signupForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">First Name</label>
                            <input type="text" name="firstName" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="lastName" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Date of Birth</label>
                            <input type="date" name="dob" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" name="confirmPassword" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" required class="form-checkbox text-pink-600">
                        <span class="ml-2 text-gray-600">I agree to the <a href="#" class="text-pink-600">Terms of Service</a> and <a href="#" class="text-pink-600">Privacy Policy</a></span>
                    </div>

                    <button type="submit" name="signup"
                        class="w-full py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition-all">
                        Create Account
                    </button>

                    <p class="text-center text-gray-600">
                        Already have an account? 
                        <a href="login.php" class="text-pink-600 hover:text-pink-700">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        const password = document.querySelector('input[name="password"]').value;
        const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
        }

        // Password strength validation
        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long!');
        }
    });
    </script>
</body>
</html>