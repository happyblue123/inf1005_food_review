<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not already started
    $login = isset($_SESSION['userid']);
}
?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="/home">
            <img class="logo" src="/Images/logo.png" alt="peoplereviewmovies_logo">
        </a>

        <!-- Navbar Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content - Reorganized for Mobile -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Main Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/home#genres_list">Genre</a></li>
                <li class="nav-item"><a class="nav-link" href="/chatroom">Chatrooms</a></li>
            </ul>
            <div id="search-container" class="d-none d-lg-block">
                <i class="fas fa-search"></i>
                <input class="form-control movie-search" type="text" name="movie_name" placeholder="Search for a movie..." required>
            </div>
            
            <!-- Move user profile inside collapse on mobile -->
            <div class="d-lg-none mb-2">
                <?php if ($login): ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMobile" role="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/Images/user.png" alt="User Icon" width="30" height="30">
                            <span class="ms-2">My Account</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMobile">
                            <li><a class="dropdown-item" href="/profile">My Account</a></li>
                            <li><a class="dropdown-item" href="/resetpassword">Reset Password</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="#" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login / Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Profile Icon at the Right End - Visible only on larger screens -->
        <div class="user-profile d-none d-lg-block">
            <ul class="navbar-nav ms-5">
                <li class="nav-item dropdown">
                    <?php if ($login): ?>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/Images/user.png" alt="User Icon" width="30" height="30">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/profile">My Account</a></li>
                        <li><a class="dropdown-item" href="/resetpassword">Reset Password</a></li>
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                    <?php else: ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <img src="/Images/user.png" alt="User Icon" width="30" height="30">
                    </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Fix for Login Error Message -->
<?php if (isset($_SESSION['login_error'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
        var login_error_msg = document.getElementById("login-error");
        login_error_msg.innerText = "<?php echo addslashes($_SESSION['login_error']); ?>";
        loginModal.show();
        <?php unset($_SESSION['login_error']); ?>
    });
</script>
<?php endif; ?>

<!-- LOGIN POPUP MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="gif-container">
                    <img src="/video/login.gif" alt="User GIF" width="60">
                    <img src="/Images/clapperboard.png" alt="Movie Ticket GIF" width="80">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center account-text">Don't have an account? <a href="/register">Register</a></p>
                <p id="login-error" style="color: red" class="text-center"></p>
                <form id="loginForm" action="/login" method="POST">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <img src="/Images/email.png" alt="Email Icon" width="20" height="20">
                            </span>
                            <input type="email" class="form-control" placeholder="Email ID" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <img src="/Images/padlock.png" alt="Lock Icon" width="20" height="20">
                            </span>
                            <input type="password" class="form-control" placeholder="Password" id="password" name="pwd" required>
                            <span class="input-group-text" id="toggle_pwd" style="cursor: pointer;">
                                <img id="eye-icon" src="/Images/hidden.png" alt="Show Password" width="20" height="20">
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                    </div>
                    <!-- Forgot Password Trigger -->
                    <a href="javascript:void(0)" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forgotPwdModal">
                        Forgot password?
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Forgot Password Modal -->
<div class="modal fade forgot-password-modal" id="forgotPwdModal" tabindex="-1" role="dialog" aria-labelledby="forgotPwdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header border-0 justify-content-center position-relative">
                <h5 class="modal-title m-0" id="forgotPwdModalLabel">RESET PASSWORD</h5>
                <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <!-- Modal Body -->
            <div class="modal-body">
                <p>Please enter your email address below, and we will send you a link to reset your password.</p>

                <!-- Email Input -->
                <input type="email" id="email_reset" placeholder="Email ID" required>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">SUBMIT</button>

                <!-- Feedback Message -->
                <div id="forgotPwdMessage" class="mt-2"></div>
            </div>

        </div>
    </div>
</div>
