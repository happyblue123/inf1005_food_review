<?php
require_once __DIR__ . "/../models/User.php";

class AuthController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Initialize error array
            $errors = [];
        
            // Sanitize inputs
            $username = htmlspecialchars(trim($_POST['username']));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['pwd']);
            $password_cfm = trim($_POST['pwd_confirm']);
        
            // Validate inputs
            if (empty($username)) {
                $errors[] = "Username is required.";
            }
            if (empty($email)) {
                $errors[] = "Email is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
        
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
        
            // Password length validation
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters.";
            }
            
            if ($password_cfm != $password) {
                $errors[] = "Please enter the same password.";
            }
    
            // If there are no errors, proceed with registration
            if (empty($errors)) {
                $user = new User();
                $result = $user->register($username, $email, $password_cfm);
        
                if ($result === true) {
                    // Registration successful
                    if ($result === true) {
                        // Registration successful
                        echo '<script>
                                alert("You have successfully registered, you can login now.");
                                window.location.href = "/home";
                              </script>';
                        exit();
                    }
                } 
                elseif ($result === 'duplicate') {
                    // Duplicate entry
                    $errors[] = "The email or username is already taken.";
                } 
                else {
                    // General registration failure
                    $errors[] = "Registration failed due to a system error.";
                }
            }
        
            // If there are errors, show them in an alert
            if (!empty($errors)) {
                $allErrors = implode("\\n", $errors);  // Join all errors with a newline character
                echo "<script>alert('$allErrors');</script>";
            }
        }
        
        // Load the registration view (this will show the form again if there are errors)
        require_once __DIR__ . "/../views/register.php";
    }
    
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and validate inputs first
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['pwd']);
            
            $errors = [];
    
            // Validate inputs
            if (empty($email)) {
                $errors[] = "Email is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
    
            // If there are no validation errors
            if (empty($errors)) {
                // Proceed with login logic (assume login checks email/password)
                $user = new User();
                $result = $user->login($email, $password);
                if ($result) {
                    // Successful login, redirect or show success
                    session_start();
                    $_SESSION['userid'] = $result[0];
                    $_SESSION['username'] = $result[1];
                    header("Location: /home");  // or wherever you want to redirect
                    exit();
                } else {
                    // Handle login failure (e.g., invalid credentials)
                    $errors[] = "Email or Password is incorrect.";
                }
            }
    
            // If there are errors, display them
            if (!empty($errors)) {
                $allErrors = implode("\n", $errors);  // Join all errors with a newline character
                echo "<script>alert('$allErrors');</script>";
            }
        }
    
        require_once __DIR__ . "/../views/login.php";
    }

    public function resetpwd() {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $username = $_SESSION['username'];
            $current_pwd = trim($_POST['cpwd']);
            $new_pwd = trim($_POST['newpwd']);
            $new_cfmpwd = trim($_POST['newpwd_confirm']);
            $error = "";
            // Create a new User object
            $user = new User();
            // Check if the new passwords match
            // Password length validation

            if ($new_pwd !== $new_cfmpwd) {
                // Passwords don't match, show an error
                $error = "New passwords do not match.";
                echo "<script>alert('$error');</script>";
                echo "<script>window.location.href = '/resetpassword';</script>";
                
            }

            if (strlen($new_pwd) < 6) {
                $error = "Password must be at least 6 characters.";
                echo "<script>alert('$error');</script>";
                echo "<script>window.location.href = '/resetpassword';</script>";
                exit;
            }
    
            // Validate the current password
            if (!$user->validatePassword($username, $current_pwd)) {
                // Current password is incorrect, show an error
                $error = "There was an error updating your password. Please try again.";
                echo "<script>alert('$error');</script>";
                echo "<script>window.location.href = '/resetpassword';</script>";
                exit;
            }
    
            // Update the password
            if ($user->updatePassword($username, $new_cfmpwd)) {
                // Password updated successfully
                echo '<script>alert("Password has been updated successfully.");</script>';
                echo "<script>window.location.href = '/resetpassword';</script>";
                exit;
            } 
            else {
                // Something went wrong while updating the password
                $error = "There was an error updating your password. Please try again.";
                echo "<script>alert('$error');</script>";
                echo "<script>window.location.href = '/resetpassword';</script>";
                exit;
            }
        }
        require_once __DIR__ . "/../views/resetpassword.php";
    }
    
    public function logout() {
        session_start();
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
    
        // Redirect to the login page or homepage after logout
        header('Location: /home');
        exit();
    }
    
}
?>
