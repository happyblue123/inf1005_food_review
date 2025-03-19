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
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>

        <!-- Profile Icon at the Right End -->
        <div class="user-profile">
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                <img src="/Images/user.png" alt="User Icon" width="30" height="30">
            </a>
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

                    <div class="text-center mt-3">
                    <a href="/resetpassword" class="forgot-password">Forgot password?</a>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
