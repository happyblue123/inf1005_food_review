<?php
session_start();
$login = isset($_SESSION['userid']);
if (!$login) {
    header('Location: /home');
    exit;
}
?>

<head>
    <?php
    include "inc/head.inc.php"
        ?>
</head>

<body>
    <?php
    include "inc/header.inc.php";
    ?>
    <link rel="stylesheet" href="public/css/resetpwd.css">
    <!-- <h2>Password Reset</h2> -->

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
            <?php if (!$login) {
                echo "<div class='mb-3'>
                <label for='email' class='form-label'>Email:</label>
                <input required maxlength='45' type='email' id='email' name='email' class='form-control'
                    placeholder='Enter email'>
                </div>";
            }
            ?>

            <?php
            if ($login) { // show below to users who are logged in
                echo "<div class='mb-3'>
                    <label for='cpwd' class='form-label'>Current Password:</label>
                    <input required type='password' id='cpwd' name='cpwd' class='form-control' placeholder='Enter current password'>
                </div>";
            }

            ?>
            <div class="mb-3">
                <label for="newpwd" class="form-label">New Password:</label>
                <input required type="password" id="newpwd" name="newpwd" class="form-control"
                    placeholder="Enter password" onkeyup="checkPasswordStrength()" onkeyup="checkPasswordMatch()" required>
            </div>
            <small id="password-requirements" class="text-muted">
                Password must contain at least:
                <ul>
                    <li>One uppercase letter (A-Z)</li>
                    <li>One lowercase letter (a-z)</li>
                    <li>One number (0-9)</li>
                    <li>One special character (!@#$%^&*)</li>
                    <li>Minimum 8 characters</li>
                </ul>
            </small>
            
            <div class="mb-3">
                <label for="newpwd_confirm" class="form-label">Confirm Password:</label>
                <input required type="password" id="newpwd_confirm" name="newpwd_confirm" class="form-control"
                    placeholder="Confirm password" onkeyup="checkPasswordMatch()" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </main>

    <?php
    include "inc/footer.inc.php";
    ?>

    <script>
        function checkPasswordStrength() {
            let password = document.getElementById('pwd').value;
            let passwordRequirements = document.getElementById('password-requirements');

            let uppercase = /[A-Z]/.test(password);
            let lowercase = /[a-z]/.test(password);
            let number = /[0-9]/.test(password);
            let specialChar = /[\W]/.test(password);
            let minlength = password.length >= 8;
            requirements.innerHTML = `
        Password must contain at least:
        <ul>
            <li>${uppercase ? '✅' : '❌'} One uppercase letter (A-Z)</li>
            <li>${lowercase ? '✅' : '❌'} One lowercase letter (a-z)</li>
            <li>${number ? '✅' : '❌'} One number (0-9)</li>
            <li>${specialChar ? '✅' : '❌'} One special character (!@#$%^&*)</li>
            <li>${minlength ? '✅' : '❌'} Minimum 8 characters</li>
        </ul>
        `;
        }

        function checkPasswordMatch() {
            let password = document.getElementById('pwd').value;
            let confirmPassword = document.getElementById('pwd_confirm').value;
            let submitBtn = document.querySelector('.submit-btn');

            if (password === confirmPassword) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
    </script>
</body>