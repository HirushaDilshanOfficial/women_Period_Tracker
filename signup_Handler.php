<?php
define('ALLOWED_ACCESS', true);
session_start();
require_once 'config.php';
if(isset($_POST['signup'])) {
    try {
        $pdo = getDBConnection();
        
        // Get and sanitize form data
        $firstName = sanitizeInput($_POST['firstName']);
        $lastName = sanitizeInput($_POST['lastName']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = sanitizeInput($_POST['phone']);
        $dob = sanitizeInput($_POST['dob']);
        $password = $_POST['password'];
        
        // Validate input
        if(empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($dob) || empty($password)) {
            setFlashMessage('error', 'All fields are required');
            header("Location: signup.php");
            exit();
        }
        
        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlashMessage('error', 'Invalid email format');
            header("Location: signup.php");
            exit();
        }
        
        // Check password strength
        if(strlen($password) < 8) {
            setFlashMessage('error', 'Password must be at least 8 characters long');
            header("Location: signup.php");
            exit();
        }
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetchColumn() > 0) {
            setFlashMessage('error', 'Email already registered');
            header("Location: signup.php");
            exit();
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL and bind parameters
        $sql = "INSERT INTO users (first_name, last_name, email, phone, date_of_birth, password, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $firstName,
            $lastName,
            $email,
            $phone,
            $dob,
            $hashedPassword
        ]);
        
        // Set success message and redirect to login
        setFlashMessage('success', 'Account created successfully! Please login.');
        header("Location: login.php");
        exit();
        
    } catch(Exception $e) {
        error_log("Error in signup process: " . $e->getMessage());
        setFlashMessage('error', 'Registration failed. Please try again.');
        header("Location: signup.php");
        exit();
    }
}
?>