<?php
require_once __DIR__ . "/../core/Database.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $email, $password) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                return true;
            } 
            else {
                // Query execution failed
                $errorInfo = $stmt->errorInfo();
                error_log("Database error: " . $errorInfo[2]);  // Log the error to a file or output
                return false;
            }
        } 
        catch (PDOException $e) {
            // Handle duplicate entry error (Error Code: 1062)
            if ($e->getCode() == 1062 || $e->getCode() == 23000) {
                return 'duplicate';
            } 
            else {
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
        } 
        else {
            return false;
        }
    }

    public function validatePassword($userid, $current_pwd) {
        // Fetch the stored password hash from the database for the user
        $stmt = $this->db->conn->prepare("SELECT password FROM users WHERE userid = ?");
        $stmt->execute([$userid]);
        $user = $stmt->fetch();

        if ($user && password_verify($current_pwd, $user['password'])) {
            return true;
        }
        return false;
    }

    // Method to update the password
    public function updatePassword($userid, $new_pwd) {
        $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $this->db->conn->prepare("UPDATE users SET password = ? WHERE userid = ?");
        $stmt->execute([$hashed_pwd, $userid]);
        return $stmt->execute();
    }

    public function fetchprofile($userid) {
        $stmt = $this->db->conn->prepare("select username, email from users where userid = ?");
        $stmt->execute([$userid]);
        $user = $stmt->fetch();
        return $user;
    }

    public function updateProfile($userid, $username, $email) {

        $stmt = $this->db->conn->prepare("SELECT username, email FROM users WHERE userid = ?");
        $stmt->execute([$userid]);
        $currentUser = $stmt->fetch();

        if ($currentUser['username'] === $username && $currentUser['email'] === $email) {
            return true; // No changes made, still return true as no error occurred
        }

        $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM users WHERE (username = ? OR email = ?) AND userid != ?");
        $stmt->execute([$username, $email, $userid]);

        if ($stmt->fetchColumn() > 0) {
            return 'duplicate';
        }
        $updateStmt = $this->db->conn->prepare("UPDATE users SET username = ?, email = ? WHERE userid = ?");
        $updateStmt->execute([$username, $email, $userid]);
        if ($updateStmt->rowCount() > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function checkEmail($email) {
        $stmt = $this->db->conn->prepare("select userid, email, username from users where email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }
    

    public function setNewPassword($userid, $newpwd) {
        $newpwd = password_hash($newpwd, PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare("UPDATE users set password = ? WHERE userid = ?");
        $stmt->execute([$newpwd, $userid]);
    }

    public function deleteUser($userid) {
        $stmt = $this->db->conn->prepare("DELETE FROM users WHERE userid = ?");
        $stmt->execute([$userid]);
    }

}
?>
