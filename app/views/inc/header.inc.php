<!-- <header class="text-white text-center">
    <h1>My Website</h1>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            </ul>
        </div>
    </nav>
</header> -->

<!-- <link href="/public/css/header.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/home"><img id="logo" src="/Images/logo.png" alt="peoplereivewmovies_logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" 
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/login">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/register">Register</a>
      </li>
    </ul>
  </div>
</nav> -->

<!-- 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">Replace with logo!</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav> -->
      

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
            <img id="logo" src="/Images/logo.png" alt="peoplereviewmovies_logo">
        </a>

        <!-- Navbar Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items Aligned to the Left -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-3"> <!-- ms-3 adds left margin for spacing -->
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>
        
        <!-- Profile Icon at the Right End -->
        <div class="user-profile">
            <ul class="navbar-nav ms-5">
                <li class="nav-item dropdown">
                    <?php if ($login): ?>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/Images/user.png" alt="User Icon" width="30" height="30">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/profile">My Account</a>
                        <a class="dropdown-item" href="/resetpassword">Reset Password</a>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
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
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
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
                            <input type="email" class="form-control" placeholder="Email ID" id="email" name="email"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <img src="/Images/padlock.png" alt="Lock Icon" width="20" height="20">
                            </span>
                            <input type="password" class="form-control" placeholder="Password" id="password"
                                name="pwd" required>
                            <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <img id="eye-icon" src="/Images/hidden.png" alt="Show Password" width="20" height="20">
                            </span>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                    </div>

                    <!-- Forgot Password Trigger -->
<a href="javascript:void(0)" class="forgot-password" data-toggle="modal" data-target="#forgotPwdModal">
  Forgot password?
</a>

<!-- Forgot Password Modal -->
<div class="modal fade forgot-password-modal" id="forgotPwdModal" tabindex="-1" role="dialog" aria-labelledby="forgotPwdModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="forgotPwdModalLabel">RESET PASSWORD</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; border: none; background: none;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <p>Please enter your email address below, and we will send you a link to reset your password.</p>

                                    <!-- Email Input -->
                                    <input type="email" id="email_reset" placeholder="Email ID" />

                                    <!-- Submit Button -->
                                    <button type="submit" onclick="submitForgotPwd()">
                                        SUBMIT
                                    </button>

                                    <!-- Feedback Message -->
                                    <div id="forgotPwdMessage" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>