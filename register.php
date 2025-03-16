<?php
include "inc/head.inc.php";
?>

<body>
    <?php
    include "inc/nav.inc.php";
    ?>

    <main class="container">
        <h1>Member Registration</h1>
        <p>
            For existing members, please
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>.
        </p>
        <form action="process_register.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label"> Username:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Username">
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

    <!-- Ensure Bootstrap JS is Included for Modal to Work -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
