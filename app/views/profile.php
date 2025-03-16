<?php
if (session_status() == PHP_SESSION_NONE) { // Check if session is not started
    session_start();
}
$login = isset($_SESSION['userid']);
if (!$login) {
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

    <main class="container">
        <h2>Edit Profile</h2>
        <form action="/updateprofile" method="POST">
            <?php if (isset($_SESSION['message'])): ?>
                    <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            
            <button type="submit">Update Profile</button>
        </form>
    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>