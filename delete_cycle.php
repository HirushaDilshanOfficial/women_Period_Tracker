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

// Delete the cycle entry from the database
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM cycle_entries WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $cycleId, 'user_id' => $_SESSION['user_id']]);

    if ($stmt->rowCount() > 0) {
        setFlashMessage('success', 'Cycle deleted successfully!');
    } else {
        setFlashMessage('error', 'Cycle not found or you do not have permission to delete it.');
    }
} catch (PDOException $e) {
    error_log("Error deleting cycle: " . $e->getMessage());
    setFlashMessage('error', 'Failed to delete cycle. Please try again.');
}

header('Location: profile.php');
exit();
?>