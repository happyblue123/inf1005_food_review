<?php
$login = isset($_SESSION['userid']);
if (!$login) {
    header('Location: /home');
    exit();
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user reviews
require_once __DIR__ . "/../models/Review.php";
$reviewModel = new Review();
$userReviews = $reviewModel->getReviewsByUserId($_SESSION['userid']);
?>

<head>
    <?php
    include "inc/head.inc.php"
    ?>
    <link rel="stylesheet" href="/public/css/profile.css">
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
        <div class="tabs">
            <div class="tab active" data-tab="account-info">Account Info</div>
            <div class="tab" data-tab="watchlist">Watchlist/Favourites</div>
            <div class="tab" data-tab="reviews">Reviews Made</div>
            <div class="tab" data-tab="edit-profile">Edit Profile</div>
        </div>
        <div id="account-info" class="tab-content active">
            <!-- Content for Account Info -->
            <h2>Account Info</h2>
            <p>Username: <?= htmlspecialchars($user['username']); ?></p>
            <p>Email: <?= htmlspecialchars($user['email']); ?></p>
        </div>
        <div id="watchlist" class="tab-content">
            <!-- Content for Watchlist/Favourites -->
            <h2>Watchlist/Favourites</h2>
            <p>Your watchlist and favourites will be displayed here.</p>
        </div>
        <div id="reviews" class="tab-content">
            <!-- Content for Reviews Made -->
            <h2>Reviews Made</h2>
            <?php if (!empty($userReviews)): ?>
                <ul>
                    <?php foreach ($userReviews as $review): ?>
                        <li>
                            <a href="/search/<?= isset($review['moviename']) ? urlencode($review['moviename']) : 'unknown'; ?>#review-<?= isset($review['reviewid']) ? $review['reviewid'] : 'unknown'; ?>">
                                <?= isset($review['moviename']) ? htmlspecialchars($review['moviename']) : 'Unknown Movie'; ?> - <?= isset($review['rating']) ? htmlspecialchars($review['rating']) : 'No Rating'; ?>/5
                            </a>
                            <p><?= isset($review['review_text']) ? htmlspecialchars($review['review_text']) : 'No Review'; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>You have not made any reviews yet.</p>
            <?php endif; ?>
        </div>
        <div id="edit-profile" class="tab-content">
            <h2>Edit Profile</h2>
            <form action="/updateprofile" method="POST">
                <?php if (isset($_SESSION['message'])): ?> 
                    <?php echo $_SESSION['message']; ?> <!-- show result after form submission -->
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
        </div>
    </main>

    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });
    </script>

    <footer>
        <?php include "inc/footer.inc.php"; ?>
    </footer>
</body>