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

    // Method to validate the current password
    public function validatePassword($username, $current_pwd) {
        // Fetch the stored password hash from the database for the user
        $stmt = $this->db->conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($current_pwd, $user['password'])) {
            return true;
        }
        return false;
    }

    // Method to update the password
    public function updatePassword($username, $new_pwd) {
        // Hash the new password before saving it
        $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $this->db->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed_pwd, $username]);
        return $stmt->execute();
    }
}
?>
