<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <title>Member Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>

    <!-- LOGIN POPUP MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">SIGN IN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Don't have an account? <a href="register.php">Register</a>.</p>
                    <form action="process_login.php" method="POST">
                        
                        <!-- Email Input -->
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img src="Images/email.png" alt="Email Icon" width="20" height="20">
                                </span>
                                <input type="email" class="form-control" placeholder="Email ID" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img src="Images/padlock.png" alt="Lock Icon" width="20" height="20">
                                </span>
                                <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                    <img id="eye-icon" src="Images/hidden.png" alt="Show Password" width="20" height="20">
                                </span>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                        </div>

                        <!-- Forgot Password -->
                        <div class="text-center mt-3">
                            <a href="forgot_password.php" class="text-decoration-none">Forgot password?</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "inc/footer.inc.php"; ?>

    <!-- Bootstrap JS (Required for Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.getElementById("eye-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.src = "Images/eye.png"; // Change to visible eye icon
        } else {
            passwordInput.type = "password";
            eyeIcon.src = "Images/hidden.png"; // Change back to hidden eye icon
        }
    }
    </script>

</body>
</html>
