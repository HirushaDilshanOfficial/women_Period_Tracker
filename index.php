<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FemCare - Comprehensive period tracking and menstrual health monitoring">
    <title>FemCare - Period Tracker</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Base Styles -->
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #EC4899 0%, #8B5CF6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen bg-pink-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-heart text-pink-600 text-2xl"></i>
                    <span class="text-2xl font-bold gradient-text">FemCare</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-pink-600 transition-colors">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-pink-600 transition-colors">Features</a>
                    <a href="#about" class="text-gray-700 hover:text-pink-600 transition-colors">About</a>
                    <!-- Login Button -->
                    <button 
                        onclick="window.location.href='Login.php'" 
                        class="text-pink-600 hover:text-pink-700 transition-colors">
                        Login
                    </button>

                    <!-- Sign Up Button -->
                    <button 
                        onclick="window.location.href='Signup.php'" 
                        class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-2 rounded-full hover:opacity-90 transition-all transform hover:scale-105">
                        Sign Up
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMenu()" class="text-gray-600 hover:text-pink-600 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
                <div id="mobileMenu" class="hidden md:hidden pb-4">
                    <a href="#" class="block py-2 text-gray-700 hover:text-pink-600">Home</a>
                    <a href="#features" class="block py-2 text-gray-700 hover:text-pink-600">Features</a>
                    <a href="#about" class="block py-2 text-gray-700 hover:text-pink-600">About</a>
                    <button 
                        onclick="window.location.href='Login.php'" 
                        class="block w-full text-left py-2 text-gray-700 hover:text-pink-600">
                        Login
                    </button>
                    <button 
                        onclick="window.location.href='Signup.php'" 
                        class="w-full mt-2 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-4 py-2 rounded-full">
                        Sign Up
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 px-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <!-- Left Content -->
            <div class="md:w-1/2">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Take Control of Your 
                    <span class="gradient-text">Menstrual Health</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Track your cycle, understand your body, and get personalized insights with our 
                    AI-powered period tracking system.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-8 py-3 rounded-full hover:opacity-90 transition-all transform hover:scale-105">
                        Start Your Journey
                    </button>
                    <button class="group border-2 border-pink-600 text-pink-600 px-8 py-3 rounded-full hover:bg-pink-50 transition-all flex items-center space-x-2">
    <div class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center group-hover:bg-pink-700 transition-colors">
        <i class="fas fa-play text-white text-sm"></i>
    </div>
    <span>Watch Demo</span>
</button>
                </div>
            </div>

            <!-- Right Content (App Preview) -->
            <div class="md:w-1/2">
            <div class="relative max-w-md mx-auto">
                <!-- Changed image source to placeholder API -->
                <img 
                    src="https://images.unsplash.com/photo-1580828476460-d1c11a6704bc?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGVyaW9kfGVufDB8fDB8fHww" 
                    alt="Woman using FemCare app on smartphone"
                    class="w-full rounded-2xl shadow-2xl object-cover"
                    width="400"
                    height="400"
                />
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-pink-200 rounded-full opacity-20"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-purple-200 rounded-full opacity-20"></div>
            </div>
        </div>
    </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
                Powerful Features for Your Health
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Smart Period Tracking</h3>
                    <p class="text-gray-600">Advanced algorithms to predict your cycle with increasing accuracy over time.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Health Analytics</h3>
                    <p class="text-gray-600">Detailed insights about your cycle patterns and symptoms over time.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Smart Reminders</h3>
                    <p class="text-gray-600">Customizable notifications for upcoming periods and fertile windows.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
                    <button onclick="toggleModal('loginModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form action="login.php" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent"
                            required>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent"
                            required>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-2 rounded-lg hover:opacity-90 transition-opacity">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <section id="how-it-works" class="py-20 bg-pink-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-16">
                How FemCare Works
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Step 1 -->
                <div class="step-card bg-white p-8 rounded-xl shadow-lg relative">
                    <div class="absolute -top-8 left-8 w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">1</div>
                    <h3 class="text-xl font-bold mb-4 mt-6">Sign Up</h3>
                    <p class="text-gray-600">Create your account and start tracking your menstrual cycle with our easy-to-use interface.</p>
                </div>

                <!-- Step 2 -->
                <div class="step-card bg-white p-8 rounded-xl shadow-lg relative">
                    <div class="absolute -top-8 left-8 w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">2</div>
                    <h3 class="text-xl font-bold mb-4 mt-6">Track Your Cycle</h3>
                    <p class="text-gray-600">Log your periods, symptoms, and mood to help our AI understand your unique patterns.</p>
                </div>

                <!-- Step 3 -->
                <div class="step-card bg-white p-8 rounded-xl shadow-lg relative">
                    <div class="absolute -top-8 left-8 w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">3</div>
                    <h3 class="text-xl font-bold mb-4 mt-6">Get Insights</h3>
                    <p class="text-gray-600">Receive personalized predictions and health insights based on your data.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">
                What Our Users Say
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-pink-50 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Sarah M.</h4>
                            <p class="text-sm text-gray-600">Active User</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"FemCare has completely changed how I track my cycle. The predictions are incredibly accurate!"</p>
                </div>

                <div class="bg-pink-50 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Sarah M.</h4>
                            <p class="text-sm text-gray-600">Active User</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"FemCare has completely changed how I track my cycle. The predictions are incredibly accurate!"</p>
                </div>


                <div class="bg-pink-50 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Sarah M.</h4>
                            <p class="text-sm text-gray-600">Active User</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"FemCare has completely changed how I track my cycle. The predictions are incredibly accurate!"</p>
                </div>

                <!-- [Add more testimonials similarly] -->
            </div>
        </div>

        
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <i class="fas fa-heart text-pink-600 text-2xl"></i>
                        <span class="text-2xl font-bold gradient-text">FemCare</span>
                    </div>
                    <p class="text-gray-400">Empowering women through technology and health insights.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">Home</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-pink-500 transition-colors">Features</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-pink-500 transition-colors">How It Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">About Us</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Stay Updated</h3>
                    <form class="space-y-4">
                        <input type="email" placeholder="Enter your email" 
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-pink-500">
                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:opacity-90 transition-all">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; 2024 FemCare. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Modal Toggle
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>