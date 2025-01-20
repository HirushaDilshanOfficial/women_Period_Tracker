<?php
// First check if the constant is not already defined
if (!defined('ALLOWED_ACCESS')) {
    define('ALLOWED_ACCESS', true);
}

// Include configuration file which handles session setup
require_once 'config.php';

class LoginHandler {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    /**
     * Handle login attempt
     * @param string $email User email
     * @param string $password User password
     * @return array Success status and message
     */
    public function handleLogin($email, $password) {
        try {
            // Prepare statement to prevent SQL injection
            $stmt = $this->pdo->prepare("SELECT id, email, password, first_name, last_name FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['logged_in'] = true;
                
                // Update last login timestamp
                $this->updateLastLogin($user['id']);
                
                return ['success' => true];
            }
            
            return ['success' => false, 'message' => 'Invalid email or password'];
            
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred during login'];
        }
    }
    
    /**
     * Update user's last login timestamp
     * @param int $userId User ID
     */
    private function updateLastLogin($userId) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $userId]);
        } catch (PDOException $e) {
            error_log("Error updating last login: " . $e->getMessage());
        }
    }
    
    /**
     * Check if user is authenticated
     * @return bool Authentication status
     */
    public function checkAuth() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get user profile data
     * @param int $userId User ID
     * @return array|false User data or false on failure
     */
    public function getUserProfile($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Profile fetch error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Handle logout
     */
    public function logout() {
        // Unset all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destroy the session
        session_destroy();
    }
}

// Initialize login handler
$loginHandler = new LoginHandler();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $result = $loginHandler->handleLogin($email, $password);
        
        if ($result['success']) {
            // Set remember me cookie if requested
            if (isset($_POST['remember']) && $_POST['remember'] === 'on') {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (86400 * 30), '/', '', true, true);
            }
            
            header('Location: profile.php');
            exit();
        } else {
            $error = $result['message'];
        }
    }
}