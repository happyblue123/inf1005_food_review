<?php
/*
session_start();
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
    <h2>Login</h2>

    <main class="container">
        <form action='/login' method="POST">
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
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>
*/