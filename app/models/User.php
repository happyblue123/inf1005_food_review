<?php
require_once __DIR__ . "/../core/Database.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $email, $password) {
        try {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare SQL query to insert new user
            $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            
            // Execute the statement
            if ($stmt->execute([$username, $email, $hashed_password])) {
                return true;  // Registration successful
            } else {
                // Log or inspect errors if the execution fails
                $errorInfo = $stmt->errorInfo();
                error_log("Database error: " . $errorInfo[2]);  // Log the error to a file or output
                return false;  // Query execution failed
            }
        } catch (PDOException $e) {
            // Handle duplicate entry error (Error Code: 1062)
            if ($e->getCode() == 1062 || $e->getCode() == 23000) {
                
                return 'duplicate';  // Return 1062 for duplicate entry
            } else {
                // Log any other database-specific errors
                error_log("PDO error: " . $e->getMessage());
                return false;
            }
        }
    }
    

    public function login($email, $password) {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return [$user['userid'], $user['username']];
        } else {
            return false;
        }
    }
}
?>
