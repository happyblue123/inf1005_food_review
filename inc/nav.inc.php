<nav class="navbar navbar-expand-lg bg-secondary" data-bs-theme="dark"> 
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                <li class="nav-item"> 
                    <a class="nav-link" href="/index.php">Home</a> 
                </li> 
                <!-- User Icon to Open Login Popup -->
                <li class="nav-item"> 
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <img src="Images/user.png" alt="User Icon" width="30" height="30" style="cursor: pointer;">
                    </a>
                </li>
            </ul> 
        </div>
    </div>
</nav>

<!-- LOGIN POPUP MODAL (Ensures it works on ALL pages) -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" 
     aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">SIGN IN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Don't have an account? <a href="register.php">Register</a>.</p>
                <form id="loginForm" action="process_login.php" method="POST">
                
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

<!-- Ensure Bootstrap JS is Included for Modal to Work -->
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

// Auto-reset form when modal closes
document.addEventListener("DOMContentLoaded", function () {
    var loginModal = document.getElementById('loginModal');

    loginModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('loginForm').reset(); // Reset form when modal closes
    });
});
</script>
