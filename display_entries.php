<?php
require 'config.php';

try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM sympton ORDER BY start_date DESC");
    $entries = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycle Entries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 p-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Cycle Entries</h1>
        <div class="space-y-4">
            <?php foreach ($entries as $entry): ?>
                <div class="bg-white p-6 rounded-2xl">
                    <div class="text-gray-700">Date: <?php echo htmlspecialchars($entry['start_date']); ?></div>
                    <div class="text-gray-700">Symptoms: <?php echo htmlspecialchars($entry['symptoms']); ?></div>
                    <div class="text-gray-700">Mood: <?php echo htmlspecialchars($entry['moods']); ?></div>
                    <div class="text-gray-700">Flow Intensity: <?php echo htmlspecialchars($entry['flow_intensity']); ?></div>
                    <div class="text-gray-700">Notes: <?php echo htmlspecialchars($entry['notes']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>