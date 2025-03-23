<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);
if ($login) {
    header('Location: /home');
    exit();
}
?>

<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="public/css/register.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>

<body>
    <?php
    if ($login) {
        include "inc/headerwlogout.inc.php";
    } else {
        include "inc/header.inc.php";
    }
    ?>

    
    <main class="container">
        <?php if(isset($_SESSION['register_result'])): ?>
            <?php if ($_SESSION['register_result'][0] === 1): ?>
                <p class='form-title' style="color: green"><?php echo $_SESSION['register_result'][1]; ?></p>
            <?php else: ?>
                <p class='form-title' style="color: red"><?php echo $_SESSION['register_result'][1]; ?></p>
            <?php endif; ?>
             
            <?php unset($_SESSION['register_result']); ?>
        <?php endif; ?>
        <h2 class="form-title">PERSONAL DETAILS</h2>
        <form action='/register' method="POST">
            <label for="username" class="form-label">USERNAME</label>
            <div class="mb-3">
                <input type="text" id="username" name="username" class="form-control">
            </div>

            <label for="email" class="form-label">E-MAIL ADDRESS</label>
            <div class="mb-3">
                <input required type="email" id="email" name="email" class="form-control">
            </div>

            <label for="pwd" class="form-label">PASSWORD</label>
            <div class="mb-3 password-container">
                <input required type="password" class="form-control" id="pwd" name="pwd">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon1" onclick="togglePassword('pwd', 'eye-icon1')">
            </div>

            <label for="pwd_confirm" class="form-label">CONFIRM PASSWORD</label>
            <div class="mb-3 password-container">
                <input required type="password" class="form-control" id="pwd_confirm" name="pwd_confirm">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon2" onclick="togglePassword('pwd_confirm', 'eye-icon2')">
            </div>

            <div class="checkbox-container">
                <input required type="checkbox" id="agree" name="agree">
                <label for="agree">I accept the <a href="#" class="privacy-link">privacy statement</a></label>
            </div>

            <button type="submit" class="submit-btn">CREATE ACCOUNT</button>

            
            <p class="text-center account-text">
    Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
</p>

        </form>
    </main>

    <?php include "inc/footer.inc.php"; ?>

    
    <script>
        function togglePassword(inputId, eyeIconId) {
            var passwordInput = document.getElementById(inputId);
            var eyeIcon = document.getElementById(eyeIconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.src = "/Images/eye.png"; // Change to open eye icon
            } else {
                passwordInput.type = "password";
                eyeIcon.src = "/Images/hidden.png"; // Change back to hidden eye icon
            }
        }
    </script>
</body>
