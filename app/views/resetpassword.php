<?php
session_start();
$login = isset($_SESSION['userid']);
if (!$login) {
    header('Location: /home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "inc/head.inc.php"
    ?>
    <link href="stylesheet" src="/public/css/resetpwd.css"></link>
</head>

<body>
    <?php
    include "inc/header.inc.php";
    ?>
    <link rel="stylesheet" href="public/css/resetpwd.css">
    <!-- <h2>Password Reset</h2> -->

    <main class="container">

        <?php if(isset($_SESSION['resetpwd_result'])): ?>
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
                <input required type="password" id="newpwd" name="newpwd" class="form-control" placeholder="Enter password">
            </div>
            <div class="mb-3">
                <label for="newpwd_confirm" class="form-label">Confirm Password:</label>
                <input required type="password" id="newpwd_confirm" name="newpwd_confirm" class="form-control"
                    placeholder="Confirm password">
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
</html>