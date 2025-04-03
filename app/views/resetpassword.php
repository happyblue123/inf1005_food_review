<?php
session_start();
$login = isset($_SESSION['userid']);
if (!$login) {
    header('Location: /home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/public/css/resetpwd.css">
</head>

<body>
    <?php include "inc/header.inc.php"; ?>

    <main class="container">
        <?php if (isset($_SESSION['resetpwd_result'])): ?>
            <?php 
            $registerClass = ($_SESSION['resetpwd_result'][0] === 1) ? 'success' : 'error'; 
            $message = $_SESSION['resetpwd_result'][1];
            ?>
            <p class="resetpwd-result <?php echo $registerClass; ?>"><?php echo $message; ?></p>
            <?php unset($_SESSION['resetpwd_result']); ?>
        <?php endif; ?>

        <form action='/resetpassword' method="POST">
            <div class='mb-3 password-container'>
                <label for='cpwd' class='form-label'>Current Password:</label>
                <input required type='password' id='cpwd' name='cpwd' class='form-control' placeholder='Enter current password'>
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon1"
                    onclick="togglePassword('cpwd', 'eye-icon1')">
            </div>

            <div class="mb-3 password-container">
                <label for="newpwd" class="form-label">New Password:</label>
                <input required type="password" id="newpwd" name="newpwd" class="form-control" placeholder="Enter password">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon2"
                    onclick="togglePassword('newpwd', 'eye-icon2')">
            </div>

            <div class="mb-3 password-container">
                <label for="newpwd_confirm" class="form-label">Confirm Password:</label>
                <input required type="password" id="newpwd_confirm" name="newpwd_confirm" class="form-control"
                    placeholder="Confirm password">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon3"
                    onclick="togglePassword('newpwd_confirm', 'eye-icon3')">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </main>

    <?php include "inc/footer.inc.php"; ?>

    <script>
        function togglePassword(inputId, eyeIconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(eyeIconId);
            if (input.type === "password") {
                input.type = "text";
                icon.src = "/Images/eye.png";
            } else {
                input.type = "password";
                icon.src = "/Images/hidden.png";
            }
        }
    </script>
</body>
</html>
