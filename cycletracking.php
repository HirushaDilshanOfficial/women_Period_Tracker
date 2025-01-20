<?php
define('ALLOWED_ACCESS', true);
require_once 'cycletracking_backend.php';

// Prevent direct access
if (!defined('ALLOWED_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access forbidden');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare Pro - Advanced Cycle Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-heart text-pink-600 text-2xl"></i>
                    <span class="text-2xl font-bold gradient-text">FemCare</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="profile.php" class="p-2 rounded-full hover:bg-pink-50">
                        <i class="fas fa-user text-gray-600"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Tracking Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-calendar-alt text-pink-600 mr-3"></i>
                        Track Your Cycle
                    </h2>
                    
                    <form id="cycleForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Period Start Date</label>
                                <div class="relative">
                                    <input type="date" id="startDate" name="startDate" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Period End Date</label>
                                <div class="relative">
                                    <input type="date" id="endDate" name="endDate" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                                </div>
                            </div>
                        </div>

                        <!-- Flow Intensity Slider -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Flow Intensity</label>
                            <input type="range" min="1" max="5" value="3" class="w-full accent-pink-600" id="flowIntensity">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Light</span>
                                <span>Heavy</span>
                            </div>
                        </div>

                        <!-- Symptoms and Mood -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-semibold text-gray-900">Symptoms & Mood</h3>
                            
                            <div class="flex flex-wrap gap-3">
                                <button type="button" class="symptom-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-head-side-virus mr-2 text-pink-500"></i>Headache
                                </button>
                                <button type="button" class="symptom-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-tired mr-2 text-pink-500"></i>Fatigue
                                </button>
                                <button type="button" class="symptom-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-bolt mr-2 text-pink-500"></i>Cramps
                                </button>
                                <button type="button" class="symptom-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-cloud-rain mr-2 text-pink-500"></i>Bloating
                                </button>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button type="button" class="mood-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-smile mr-2 text-yellow-500"></i>Happy
                                </button>
                                <button type="button" class="mood-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-frown mr-2 text-blue-500"></i>Sad
                                </button>
                                <button type="button" class="mood-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-angry mr-2 text-red-500"></i>Irritated
                                </button>
                                <button type="button" class="mood-btn px-4 py-2 rounded-full border border-gray-300 hover:bg-pink-100 hover:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-600">
                                    <i class="fas fa-meh mr-2 text-gray-500"></i>Neutral
                                </button>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Notes</label>
                            <textarea id="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"
                                placeholder="Add any additional notes about your day..."></textarea>
                        </div>

                        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2">
                            Save Entry
                        </button>
                    </form>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-8">
                <!-- Cycle Statistics -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Cycle Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Average Cycle Length</span>
                            <span class="text-lg font-semibold text-pink-600" id="avgCycleLength">
                                <?php echo $avgCycleLength; ?> days
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Average Period Length</span>
                            <span class="text-lg font-semibold text-pink-600" id="avgPeriodLength">
                                <?php echo $avgPeriodLength; ?> days
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Next Period In</span>
                            <span class="text-lg font-semibold text-pink-600" id="nextPeriodCountdown">
                                <?php echo $nextPeriodIn; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Cycle Phase -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Current Phase</h3>
                    <div class="text-center p-4 bg-pink-50 rounded-xl">
                        <i class="fas fa-moon text-pink-600 text-3xl mb-2"></i>
                        <p class="text-lg font-semibold text-pink-600" id="currentPhase">
                            <?php echo $currentPhase; ?>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            Day <?php echo $cycleDay; ?> of <?php echo $avgCycleLength; ?>
                        </p>
                    </div>
                </div>

                <!-- Symptoms Chart -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Symptom Trends</h3>
                    <canvas id="symptomsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize symptoms chart with PHP data
            const ctx = document.getElementById('symptomsChart').getContext('2d');
            const chartData = <?php echo json_encode($chartData); ?>;

            // Convert chartData to the format expected by Chart.js
            const labels = ['Day 1', 'Day 7', 'Day 14', 'Day 21', 'Day 28'];
            const datasets = Object.keys(chartData).map(symptom => ({
                label: symptom,
                data: chartData[symptom],
                borderColor: 'rgb(219, 39, 119)',
                tension: 0.4
            }));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5
                        }
                    }
                }
            });

            // Toggle buttons
            const toggleButton = (button) => {
                button.classList.toggle('bg-pink-100');
                button.classList.toggle('border-pink-500');
            };

            document.querySelectorAll('.symptom-btn, .mood-btn').forEach(button => {
                button.addEventListener('click', () => toggleButton(button));
            });

            // Form handling
            const cycleForm = document.getElementById('cycleForm');
            cycleForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Get selected symptoms and moods
                const selectedSymptoms = Array.from(document.querySelectorAll('.symptom-btn.bg-pink-100'))
                    .map(btn => btn.textContent.trim());
                
                const selectedMoods = Array.from(document.querySelectorAll('.mood-btn.bg-pink-100'))
                    .map(btn => btn.textContent.trim());
                
                // Prepare form data
                const formData = {
                    startDate: document.getElementById('startDate').value,
                    endDate: document.getElementById('endDate').value,
                    flowIntensity: document.getElementById('flowIntensity').value,
                    notes: document.getElementById('notes').value,
                    symptoms: selectedSymptoms,
                    moods: selectedMoods
                };

                try {
                    // Send data to server
                    const response = await fetch('cycletracking_backend.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'save_entry',
                            ...formData
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        // Update statistics if provided
                        if (data.stats) {
                            document.getElementById('avgCycleLength').textContent = 
                                `${data.stats.avg_cycle_length} days`;
                            document.getElementById('avgPeriodLength').textContent = 
                                `${data.stats.avg_period_length} days`;
                            
                            // Update next period countdown
                            const cycleDay = parseInt(document.querySelector('.text-sm.text-gray-600.mt-2')
                                .textContent.split(' ')[1]);
                            const daysLeft = data.stats.avg_cycle_length - cycleDay;
                            document.getElementById('nextPeriodCountdown').textContent = 
                                daysLeft <= 0 ? 'Due now' : `${daysLeft} days`;
                        }
                        
                        // Update current phase if provided
                        if (data.currentPhase) {
                            document.getElementById('currentPhase').textContent = data.currentPhase;
                        }

                        // Show success message
                        showNotification('Entry saved successfully!', 'success');

                        // Reset form
                        cycleForm.reset();
                        document.querySelectorAll('.symptom-btn.bg-pink-100, .mood-btn.bg-pink-100')
                            .forEach(btn => {
                                btn.classList.remove('bg-pink-100', 'border-pink-500');
                            });
                    } else {
                        throw new Error(data.error || 'Failed to save entry');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Failed to save entry. Please try again.', 'error');
                }
            });

            // Validation
            document.getElementById('endDate').addEventListener('change', function() {
                const startDate = new Date(document.getElementById('startDate').value);
                const endDate = new Date(this.value);
                
                if (endDate < startDate) {
                    showNotification('End date cannot be before start date', 'error');
                    this.value = '';
                }
            });

            // Helper function for notifications
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Date input restrictions
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').setAttribute('max', today);
            document.getElementById('endDate');
        });
    </script>
</body>
</html>