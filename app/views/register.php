<?php
session_start(); // Start the session
$login = isset($_SESSION['userid']);
if ($login) {
    header('Location: /home');
    exit();
}
?>

<head>
    <?php
    include "inc/head.inc.php"
        ?>
</head>

<body>
    <?php
    if ($login) {
        include "inc/headerwlogout.inc.php";
    }
    else {
        include "inc/header.inc.php";
    }
    ?>
    <h2>Register</h2>

    <main class="container">
        <form action='/register' method="POST">
            <div class="mb-3">
                <label for="username" class="form-label"> Name:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input required maxlength="45" type="email" id="email" name="email" class="form-control"
                    placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input required type="password" id="pwd" name="pwd" class="form-control" placeholder="Enter password">
            </div>
            <div class="mb-3">
                <label for="pwd_confirm" class="form-label">Confirm Password:</label>
                <input required type="password" id="pwd_confirm" name="pwd_confirm" class="form-control"
                    placeholder="Confirm password">
            </div>
            <div class="mb-3 form-check">
                <input required type="checkbox" name="agree" id="agree" class="form-check-input">
                <label class="form-check-label" for="agree">
                    Agree to terms and conditions.
                </label>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>