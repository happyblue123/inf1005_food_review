
<?php
include "inc/head.inc.php"
?>


<body>
    <?php
    include "inc/header.inc.php";
    ?>
    <h2>Register</h2>

    <main class="container">
        <p>
            For existing members, please go to the
            <a href="sign_in.php">Sign In page</a>.
        </p>
        <form action="/process/process_register.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label"> Name:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter name">
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