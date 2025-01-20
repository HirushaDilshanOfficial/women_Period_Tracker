<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body class="bg-pink-50 p-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Top Navigation -->
        <div class="bg-white rounded-2xl p-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="profile.php" class="text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <input type="date" id="trackingDate" class="text-gray-700" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="flex space-x-4 text-sm">
                <div class="text-rose-500">
                    🌙 Cycle Day 14
                </div>
                <div class="text-purple-500">
                    🗓 Period in 14 days
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <button class="bg-white p-6 rounded-2xl flex flex-col items-center text-rose-500" onclick="openSymptomsModal()">
                <span class="text-2xl mb-2">+</span>
                <span class="text-sm">Log Symptoms</span>
            </button>
            <button class="bg-white p-6 rounded-2xl flex flex-col items-center text-purple-500" onclick="logMedicine()">
                <span class="text-2xl mb-2">💊</span>
                <span class="text-sm">Take Medicine</span>
            </button>
            <button class="bg-white p-6 rounded-2xl flex flex-col items-center text-red-500" onclick="trackExercise()">
                <span class="text-2xl mb-2">❤️</span>
                <span class="text-sm">Track Exercise</span>
            </button>
            <button class="bg-white p-6 rounded-2xl flex flex-col items-center text-blue-500" onclick="logWater()">
                <span class="text-2xl mb-2">💧</span>
                <span class="text-sm">Log Water</span>
            </button>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Symptoms -->
                <div class="bg-white rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-gray-700">🩺 Symptoms</h3>
                        <button class="text-rose-500 text-2xl" onclick="openSymptomsModal()">+</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3" id="symptomsList">
                        <!-- Symptoms will be dynamically added here -->
                    </div>
                </div>

                <!-- Mood -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-gray-700 mb-4">😊 Mood</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <button class="p-4 rounded-xl bg-purple-50" onclick="selectMood(this)">😊</button>
                        <button class="p-4 rounded-xl" onclick="selectMood(this)">😢</button>
                        <button class="p-4 rounded-xl" onclick="selectMood(this)">😠</button>
                        <button class="p-4 rounded-xl" onclick="selectMood(this)">😐</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Period Flow -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-gray-700 mb-4">💧 Period Flow</h3>
                    <div class="flex justify-between">
                        <button class="h-12 w-12 rounded-full bg-rose-100" onclick="selectFlow(this, 'light')">
                            <div class="h-3 w-3 bg-rose-300 rounded-full mx-auto"></div>
                        </button>
                        <button class="h-12 w-12 rounded-full bg-rose-100" onclick="selectFlow(this, 'medium')">
                            <div class="h-3 w-3 bg-rose-400 rounded-full mx-auto"></div>
                        </button>
                        <button class="h-12 w-12 rounded-full bg-rose-100" onclick="selectFlow(this, 'heavy')">
                            <div class="h-3 w-3 bg-rose-500 rounded-full mx-auto"></div>
                        </button>
                        <button class="h-12 w-12 rounded-full bg-rose-100" onclick="selectFlow(this, 'very_heavy')">
                            <div class="h-3 w-3 bg-rose-600 rounded-full mx-auto"></div>
                        </button>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-gray-700 mb-4">📝 Notes</h3>
                    <textarea class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" rows="4" placeholder="Add your notes here..."></textarea>
                </div>

                <!-- Cycle Overview -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-gray-700 mb-4">📊 Cycle Overview</h3>
                    <canvas id="cycleChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="fixed bottom-8 right-8">
            <button class="px-6 py-3 bg-rose-500 text-white rounded-full shadow-lg hover:opacity-90 transition-opacity" onclick="saveEntry()">
                Save Entry
            </button>
        </div>

        <!-- Symptoms Modal -->
        <div id="symptomsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white rounded-2xl p-6 w-96">
                <h3 class="text-gray-700 mb-4">🩺 Add Symptoms</h3>
                <div class="space-y-3">
                    <input type="text" id="newSymptom" class="w-full p-3 border border-gray-200 rounded-xl" placeholder="Enter a new symptom">
                    <button class="w-full px-4 py-2 bg-rose-500 text-white rounded-xl" onclick="addSymptom()">Add Symptom</button>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-xl" onclick="closeSymptomsModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Initialize Chart
        const ctx = document.getElementById('cycleChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1', '5', '10', '15', '20', '25', '28'],
                datasets: [{
                    data: [4, 3.5, 2.5, 1, 2, 3, 4],
                    borderColor: '#F472B6',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 4,
                        grid: {
                            color: '#F9FAFB'
                        }
                    },
                    x: {
                        grid: {
                            color: '#F9FAFB'
                        }
                    }
                }
            }
        });

        // Function to open symptoms modal
        function openSymptomsModal() {
            document.getElementById('symptomsModal').classList.remove('hidden');
        }

        // Function to close symptoms modal
        function closeSymptomsModal() {
            document.getElementById('symptomsModal').classList.add('hidden');
        }

        // Function to add a new symptom
        function addSymptom() {
            const symptom = document.getElementById('newSymptom').value.trim();
            if (symptom) {
                const symptomsList = document.getElementById('symptomsList');
                const symptomButton = document.createElement('button');
                symptomButton.className = 'p-3 rounded-xl bg-rose-50 text-rose-500 text-left';
                symptomButton.textContent = symptom;
                symptomButton.onclick = function() { toggleSymptom(this); };
                symptomsList.appendChild(symptomButton);
                document.getElementById('newSymptom').value = '';
                closeSymptomsModal();
            }
        }

        // Function to toggle symptom selection
        function toggleSymptom(button) {
            button.classList.toggle('bg-rose-50');
            button.classList.toggle('text-rose-500');
            button.classList.toggle('border');
            button.classList.toggle('border-gray-200');
            button.classList.toggle('text-gray-600');
        }

        // Function to select mood
        function selectMood(button) {
            document.querySelectorAll('.bg-purple-50').forEach(el => el.classList.remove('bg-purple-50'));
            button.classList.add('bg-purple-50');
        }

        // Function to select flow intensity
        let selectedFlow = null;
        function selectFlow(button, intensity) {
            if (selectedFlow) {
                selectedFlow.classList.remove('bg-rose-200');
            }
            button.classList.add('bg-rose-200');
            selectedFlow = button;
            selectedFlow.dataset.intensity = intensity;
        }

        // Function to log medicine
        function logMedicine() {
            alert('Medicine logged!');
        }

        // Function to track exercise
        function trackExercise() {
            alert('Exercise tracked!');
        }

        // Function to log water
        function logWater() {
            alert('Water logged!');
        }

        // Save functionality
        async function saveEntry() {
            try {
                const data = {
                    date: document.getElementById('trackingDate').value,
                    symptoms: Array.from(document.querySelectorAll('.bg-rose-50')).map(el => el.textContent.trim()),
                    mood: document.querySelector('.bg-purple-50')?.textContent || null,
                    flow: selectedFlow?.dataset.intensity || null,
                    notes: document.querySelector('textarea').value
                };

                const response = await fetch('save_entry.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
                if (result.status === 'success') {
                    alert('Entry saved successfully!');
                } else {
                    throw new Error(result.message || 'Failed to save');
                }
            } catch (error) {
                alert('Error saving entry. Please try again.');
                console.error('Error:', error);
            }
        }
    </script>
</body>
</html>