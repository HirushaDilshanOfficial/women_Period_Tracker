<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare - Notifications & Reminders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen">

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
    <div class="max-w-7xl mx-auto px-4 py-24">
        <!-- Notifications & Reminders Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Notifications & Reminders</h2>
            
            <!-- Notification Settings -->
            <div class="space-y-8">
                <!-- Period Reminders -->
                <div class="bg-pink-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Period Reminders</h3>
                            <p class="text-gray-600 text-sm mt-1">Get notified before your next period</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-600"></div>
                        </label>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-4">
                        <button class="px-4 py-2 rounded-full bg-white border border-pink-200 hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-600">
                            2 days before
                        </button>
                        <button class="px-4 py-2 rounded-full bg-pink-100 border border-pink-500 hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-600">
                            1 day before
                        </button>
                        <button class="px-4 py-2 rounded-full bg-white border border-pink-200 hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-600">
                            On the day
                        </button>
                    </div>
                </div>

                <!-- Ovulation & Fertile Window -->
                <div class="bg-purple-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Fertility Notifications</h3>
                            <p class="text-gray-600 text-sm mt-1">Track ovulation and fertile days</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    <div class="space-y-4 mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Ovulation Day Alert</span>
                            <input type="time" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="09:00">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Fertile Window Reminders</span>
                            <input type="time" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="10:00">
                        </div>
                    </div>
                </div>

                <!-- Medication Reminders -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Medication Reminders</h3>
                            <p class="text-gray-600 text-sm mt-1">Never miss your medications</p>
                        </div>
                        <button id="addMedicationBtn" class="text-blue-600 hover:text-blue-700 focus:outline-none">
                            <i class="fas fa-plus-circle text-2xl"></i>
                        </button>
                    </div>

                    <!-- Add/Edit Medication Form -->
                    <div id="medicationForm" class="hidden bg-white rounded-lg p-4 border border-blue-100 mb-4">
                        <h4 class="font-medium text-gray-900 mb-4">
                            <span id="formTitle">Add New Medication</span>
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                                <input type="text" id="medicationName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter medication name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Reminder Time</label>
                                <input type="time" id="medicationTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div class="flex gap-2">
                                <button id="saveMedicationBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                    Save Medication
                                </button>
                                <button id="cancelMedicationBtn" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="editingId" value="">
                    </div>

                    <!-- Medication List -->
                    <div id="medicationList" class="space-y-4 mt-4">
                        <!-- Medications will be added here dynamically -->
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-8">
                <button id="savePreferencesBtn" class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-lg hover:opacity-90 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2">
                    Save Preferences
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial medications data
            const initialMedications = [
                { id: 1, name: 'Birth Control', time: '21:00' },
                { id: 2, name: 'Vitamins', time: '08:00' }
            ];

            // Elements
            const medicationForm = document.getElementById('medicationForm');
            const formTitle = document.getElementById('formTitle');
            const medicationName = document.getElementById('medicationName');
            const medicationTime = document.getElementById('medicationTime');
            const editingId = document.getElementById('editingId');
            const medicationList = document.getElementById('medicationList');

            // Buttons
            const addMedicationBtn = document.getElementById('addMedicationBtn');
            const saveMedicationBtn = document.getElementById('saveMedicationBtn');
            const cancelMedicationBtn = document.getElementById('cancelMedicationBtn');
            const savePreferencesBtn = document.getElementById('savePreferencesBtn');

            // Toggle reminder day buttons
            const dayButtons = document.querySelectorAll('.rounded-full');
            dayButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.classList.toggle('bg-pink-100');
                    button.classList.toggle('border-pink-500');
                    button.classList.toggle('bg-white');
                    button.classList.toggle('border-pink-200');
                });
            });

            // Format time from 24h to 12h
            function formatTime(time24) {
                const [hours, minutes] = time24.split(':');
                const period = hours >= 12 ? 'PM' : 'AM';
                const hours12 = hours % 12 || 12;
                return `${hours12}:${minutes} ${period}`;
            }

            // Add medication to list
            function addMedicationToList(id, name, time) {
                const newMedication = document.createElement('div');
                newMedication.className = 'bg-white rounded-lg p-4 border border-blue-100';
                newMedication.dataset.id = id;
                newMedication.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-pills text-blue-600 text-xl"></i>
                            <div>
                                <h4 class="font-medium text-gray-900">${name}</h4>
                                <p class="text-sm text-gray-600">Daily at ${formatTime(time)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-500 edit-med">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-gray-400 hover:text-gray-500 delete-med">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                // Add edit functionality
                newMedication.querySelector('.edit-med').addEventListener('click', () => {
                    editMedication(id, name, time);
                });

                // Add delete functionality
                newMedication.querySelector('.delete-med').addEventListener('click', () => {
                    if (confirm('Are you sure you want to delete this medication?')) {
                        newMedication.remove();
                    }
                });

                medicationList.appendChild(newMedication);
            }

            // Edit medication
            function editMedication(id, name, time) {
                formTitle.textContent = 'Edit Medication';
                medicationName.value = name;
                medicationTime.value = time;
                editingId.value = id;
                medicationForm.classList.remove('hidden');
                medicationName.focus();
            }

            // Initialize medications
            function initializeMedications() {
                initialMedications.forEach(med => {
                    addMedicationToList(med.id, med.name, med.time);
                });
            }

            // Show add medication form
            addMedicationBtn.addEventListener('click', () => {
                formTitle.textContent = 'Add New Medication';
                medicationName.value = '';
                medicationTime.value = '';
                editingId.value = '';
                medicationForm.classList.remove('hidden');
                medicationName.focus();
            });

            // Hide medication form
            cancelMedicationBtn.addEventListener('click', () => {
                medicationForm.classList.add('hidden');
                medicationName.value = '';
                medicationTime.value = '';
                editingId.value = '';
            });

            // Save medication
            saveMedicationBtn.addEventListener('click', () => {
                const name = medicationName.value.trim();
                const time = medicationTime.value;
                
                if (name && time) {
                    if (editingId.value) {
                        // Update existing medication
                        const medElement = document.querySelector(`[data-id="${editingId.value}"]`);
                        if (medElement) {
                            medElement.remove();
                        }
                        addMedicationToList(editingId.value, name, time);
                    } else {
                        // Add new medication
                        const newId = Date.now();
                        addMedicationToList(newId, name, time);
                    }

                    // Clear form and hide it
                    medicationForm.classList.add('hidden');
                    medicationName.value = '';
                    medicationTime.value = '';
                    editingId.value = '';
                } else {
                    alert('Please fill in both medication name and time');
                }
            });

            // Save all preferences
            savePreferencesBtn.addEventListener('click', () => {
                // Here you would typically save all preferences to a backend
                // For now, we'll just show a success message
                alert('All preferences saved successfully!');
            });

            // Initialize the application
            initializeMedications();

            // Add keyboard support
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !medicationForm.classList.contains('hidden')) {
                    cancelMedicationBtn.click();
                }
                if (e.key === 'Enter' && !medicationForm.classList.contains('hidden')) {
                    saveMedicationBtn.click();
                }
            });
        });
    </script>
</body>
</html>