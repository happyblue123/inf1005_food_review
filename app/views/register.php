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
    <link rel="stylesheet" href="/public/css/register.css">
</head>

<body>
    <?php
    include "inc/header.inc.php";
    ?>

    <main class="container">
        <img id="logo" src="/Images/logo.png" alt="peoplereviewmovies_logo" class="border rounded mb-5">
        <?php if (isset($_SESSION['register_result'])): ?>
            <?php
            $registerClass = ($_SESSION['register_result'][0] === 1) ? 'success' : 'error';
            $message = $_SESSION['register_result'][1];
            ?>
            <p class="register-result <?php echo $registerClass; ?>"><?php echo $message; ?></p>
            <?php unset($_SESSION['register_result']); ?>
        <?php endif; ?>
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
                <input required type="password" class="form-control" id="pwd" name="pwd" onkeyup="checkPasswordStrength()">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon1"
                    onclick="togglePassword('pwd', 'eye-icon1')">
            </div>
            <small id ="password-requirements" class="text-muted">
                Password must contain at least:
                <ul>
                    <li>One uppercase letter (A-Z)</li>
                    <li>One lowercase letter (a-z)</li>
                    <li>One number (0-9)</li>
                    <li>One special character (!@#$%^&*)</li>
                    <li>Minimum 8 characters</li>
                </ul>
            </small>
            <label for="pwd_confirm" class="form-label">CONFIRM PASSWORD</label>
            <div class="mb-3 password-container">
                <input required type="password" class="form-control" id="pwd_confirm" name="pwd_confirm">
                <img src="/Images/hidden.png" alt="Show Password" class="eye-icon" id="eye-icon2"
                    onclick="togglePassword('pwd_confirm', 'eye-icon2')">
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
        function checkPasswordStrength() {
            let password = document.getElementById("pwd").value;
            let requirements = document.getElementById("password-requirements");

            // Define the complexity rules
            let uppercase = /[A-Z]/.test(password);
            let lowercase = /[a-z]/.test(password);
            let number = /[0-9]/.test(password);
            let specialChar = /[\W]/.test(password);
            let minLength = password.length >= 8;

            // Update UI with check marks ❌✅
            requirements.innerHTML = `
        Password must contain at least:
        <ul>
            <li style="color: ${uppercase ? 'green' : 'red'}">${uppercase ? '✅' : '❌'} One uppercase letter (A-Z)</li>
            <li style="color: ${lowercase ? 'green' : 'red'}">${lowercase ? '✅' : '❌'} One lowercase letter (a-z)</li>
            <li style="color: ${number ? 'green' : 'red'}">${number ? '✅' : '❌'} One number (0-9)</li>
            <li style="color: ${specialChar ? 'green' : 'red'}">${specialChar ? '✅' : '❌'} One special character (!@#$%^&*)</li>
            <li style="color: ${minLength ? 'green' : 'red'}">${minLength ? '✅' : '❌'} Minimum 8 characters</li>
        </ul>
    `;
        }

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