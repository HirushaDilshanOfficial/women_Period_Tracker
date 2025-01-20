<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO sympton (user_id, start_date, flow_intensity, symptoms, moods, notes) VALUES (:user_id, :start_date, :flow_intensity, :symptoms, :moods, :notes)");
        
        $stmt->execute([
            ':user_id' => 1, // Replace with actual user ID from session
            ':start_date' => $data['date'],
            ':flow_intensity' => $data['flow'],
            ':symptoms' => implode(', ', $data['symptoms']),
            ':moods' => $data['mood'],
            ':notes' => $data['notes']
        ]);

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}