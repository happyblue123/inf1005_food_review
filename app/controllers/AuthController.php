<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Watchlist.php";
require_once __DIR__ . "/../models/Movie.php";

// Include Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {

    private function passwordCriteriaValidation($password) {
        // Password strength validation
        $message_pwd_criteria = [];
        $pass_password_criteria = true;
        if (strlen($password) < 8) {
            $pass_password_criteria = false;
            $message_pwd_criteria[] = "Password must be at least 8 characters.";
        }

        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            $pass_password_criteria = false;
            $message_pwd_criteria[] = "Password must contain at least one uppercase letter.";
        }

        // Check for at least one numeric character
        if (!preg_match('/\d/', $password)) {
            $pass_password_criteria = false;
            $message_pwd_criteria[] = "Password must contain at least one number.";
        }

        // Check for at least one special character
        if (!preg_match('/[\W_]/', $password)) {
            $pass_password_criteria = false;
            $message_pwd_criteria[] = "Password must contain at least one special character.";
        }
        return [$pass_password_criteria, $message_pwd_criteria];
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $message_pwd_criteria = [];
            $empty_fields = false;
            $invalid_format = false;
        
            // Sanitize inputs
            $username = htmlspecialchars(trim($_POST['username']));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['pwd']);
            $password_cfm = trim($_POST['pwd_confirm']);
        
            // Validate inputs
            if (empty($username)) {
                $empty_fields = true;
            }
            if (empty($email)) {
                $empty_fields = true;
            }
            if (empty($password)) {
                $empty_fields = true;
            }
            if ($empty_fields) {
                $message = "Input fields cannot be empty.";
                $_SESSION['register_result'] = [0, $message];
                header('Location: /register');
                exit;
            }        
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Invalid email format.";
                $_SESSION['register_result'] = [0, $message];
                header('Location: /register');
                exit;
            }
            
            // Check if password and confirm password match
            if ($password_cfm != $password) {
                $message = "Please enter the same password.";
                $_SESSION['register_result'] = [0, $message];
                header('Location: /register');  
                exit;
            }

            $result = $this->passwordCriteriaValidation($password);
            $pass_password_criteria = $result[0];
            $message_pwd_criteria = $result[1];
            // If there are no errors, proceed with registration
            if ($pass_password_criteria) {
                $user = new User();
                $result = $user->register($username, $email, $password_cfm);
        
                if ($result === true) {
                    if ($result === true) {
                        $_SESSION['register_result'] = [1, 'You have successfully registered, you can login now.'];
                    }
                } 
                elseif ($result === 'duplicate') {
                    // Duplicate entry
                    $_SESSION['register_result'] = [0, "The email or username is already taken."];
                } 
                else {
                    // General registration failure
                    $_SESSION['register_result'] = [0, "Registration failed due to a system error."];
                }
            }
            else {
                $message = implode("\n", $message_pwd_criteria);
                $_SESSION['register_result'] = [0, $message];
                header('Location: /register');
                exit;
            }
        }
        // Load the registration view (this will show the form again if there are errors)
        require_once __DIR__ . "/../views/register.php";
    }
    
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $errors = [];

            // Sanitize and validate inputs first
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['pwd']);
            
            // Validate inputs
            if (empty($email)) {
                $errors[] = "Email is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
            
            // If there are errors, display them
            if (!empty($errors)) {
                $allErrors = implode("\n", $errors);
                $_SESSION['login_error'] = $allErrors;
            }

            // If there are no validation errors, proceed with login logic (assume login checks email/password)
            if (empty($errors)) {
                $user = new User();
                $result = $user->login($email, $password);
                if ($result) {
                    // Successful login
                    $_SESSION['userid'] = $result[0];
                    $_SESSION['username'] = $result[1];
                } 
                else {
                    $login_fail_msg = "Email or Password is incorrect.";
                    $_SESSION['login_error'] = $login_fail_msg;
                }
            }
            header('Location: /home');
            
        }
        header('Location: /home');
        exit;
        require_once __DIR__ . "/../views/home.php";
    }

    public function resetpwd() {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $userid = $_SESSION['userid'];
            $current_pwd = trim($_POST['cpwd']);
            $new_pwd = trim($_POST['newpwd']);
            $new_cfmpwd = trim($_POST['newpwd_confirm']);
            $error = "";

            $user = new User();

            // Check if the new passwords match
            if ($new_pwd !== $new_cfmpwd) {
                // Passwords don't match, show an error
                $error = "Passwords do not match.";
                $_SESSION['resetpwd_result'] = [0, $error];
                header('Location: /resetpassword');
                exit;
            }
    
            // Validate the current password
            if (!$user->validatePassword($userid, $current_pwd)) {
                // Current password is incorrect, show an error
                $error = "Current password is incorrect.";
                $_SESSION['resetpwd_result'] = [0, $error];
                header('Location: /resetpassword');
                exit;
            }
            
            $result = $this->passwordCriteriaValidation($new_cfmpwd);
            $pass_password_criteria = $result[0];
            $message_pwd_criteria = $result[1];
            if (!($pass_password_criteria)) {
                $message = implode("\n", $message_pwd_criteria);
                $_SESSION['resetpwd_result'] = [0, $message];
                header('Location: /resetpassword');
                exit;
            }

            // Update the password
            if ($user->updatePassword($userid, $new_cfmpwd)) {
                $message = "Password has been updated successfully.";
                $_SESSION['resetpwd_result'] = [1, $message];
                header('Location: /resetpassword');
                exit;
            }
            else {
                // Something went wrong while updating the password
                $error = "There was an error updating your password. Please try again.";
                $_SESSION['resetpwd_result'] = [0, $error];
                header('Location: /resetpassword');
                exit;
            }
        }
        require_once __DIR__ . "/../views/resetpassword.php";
    }
    
    public function fetchprofile() {
        session_start();
        $user = new User();
        $userid = $_SESSION['userid'];
        $user = $user->fetchprofile($userid);
        
        $watchlist = new Watchlist();
        $watchlist = $watchlist->getWatchlistByUserId($userid);
        require_once __DIR__ . "/../views/profile.php";
    }

    public function updateprofile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION['message'] = "";
            $error = false; // assume no error

            $user = new User();
            $userid = $_SESSION['userid'];
            $email = $_POST['email'];
            $username = $_POST['username'];

            // check if input is empty or exceeds max length
            if (empty($email) || empty($username) || strlen($username) > 50) {
                $_SESSION['message'] = "Error updating profile, please try again.";
                header("Location: /profile");
                exit;
            }

            // Input sanitzation
            $username = filter_var(trim($username), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
            }
            
            if ($error) {
                $_SESSION['message'] = "Error updating profile, please try again.";
                header("Location: /profile");
                exit;
            }

            $result = $user->updateProfile($userid, $username, $email);
            if ($result === 'duplicate') {
                $_SESSION['message'] = "Username or Email exists.";
                header("Location:/profile");
                exit;
            }
            if ($result) {
                $_SESSION['message'] = "Profile updated successfully."; 
            }
            else {
                $_SESSION['message'] = "Error updating profile, please try again.";    
            }
            header("Location: /profile");
            exit;
        
        }
    }
    
    public function forgotPwd() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["success" => false, "message" => "Invalid request method"]);
            header('Location: /home');
            exit;
        }
    
        // Get JSON input from AJAX request
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["success" => false, "message" => "Please provide a valid email format"]);
            exit;
        }

        $email = $data['email'];
        $user = new User();
        $result = $user->checkEmail($email);
    
        if (empty($result)) { // If user is not registered, dont send email
            exit;
        }
    
        $randompwd = $this->generateRandomString();
        $username = $result['username'];
        $userid = $result['userid'];
        $user->setNewPassword($userid, $randompwd);
    
        // Use Sendinblue to send mail
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';  
            $mail->SMTPAuth = true;
            $mail->Username = '88bfda001@smtp-brevo.com';  
            $mail->Password = 'Ch7MJz9REKgFWANQ';  
            $mail->Port = 587;  
            
            // Recipients
            $mail->setFrom('2403911@sit.singaporetech.edu.sg', 'Peoples Movie');
            $mail->addAddress($email, $username);  
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Request to reset password';
            $mail->Body    = 'Your password has been set to ' . $randompwd;
            $mail->AltBody = 'Your new password is: ' . $randompwd;
            
            // Send email
            $mail->send();
    
            echo json_encode(["success" => true, "message" => "Password reset link sent"]);
            exit;
        } 
        catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Email sending failed: " . $mail->ErrorInfo]);
            exit;
        }
    }    

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function logout() {
        session_start();
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: /home');
        exit();
    }
    
}
?>
