<?php
$login = isset($_SESSION['userid']);
if (!$login) {
    header('Location: /home');
    exit();
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../models/Review.php";
require_once __DIR__ . "/../models/WatchHistory.php";
require_once __DIR__ . "/../models/Watchlist.php";

// Fetch user reviews
$reviewModel = new Review();
$userReviews = $reviewModel->getReviewsByUserId($_SESSION['userid']);

// Fetch watch history
$historyModel = new WatchHistory();
$watchHistory = $historyModel->getWatchHistoryByUserId($_SESSION['userid']);

// Fetch watchlist
$watchlistModel = new Watchlist();
$watchlist = $watchlistModel->getWatchlistByUserId($_SESSION['userid']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "inc/head.inc.php"
    ?>
    <link rel="stylesheet" href="/public/css/profile.css">
</head>

<body>
    <?php
    include "inc/header.inc.php";
    ?>

    <main class="container">
        <div class="tabs">
            <div class="tab active" data-tab="account-info">Account Info</div>
            <div class="tab" data-tab="watchlist">Watchlist/Favourites</div>
            <div class="tab" data-tab="watchhistory">Watch History</div> 
            <div class="tab" data-tab="reviews">My Reviews</div>
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
            <p>Your watchlist contains movies that you've saved for future viewing. Add your favorite movies here and access them anytime!</p>
            <?php if (!empty($watchlist)): ?>
        <ul class="watchlist-list">
            <?php foreach ($watchlist as $movie): ?>
                <li id="watchlist-movie-<?= $movie['movieid'] ?>" class="movie-watchlist-item">
                    <a href="/movie/<?= urlencode($movie['moviename']); ?>">
                        <?= htmlspecialchars($movie['moviename']); ?>
                    </a>
                    <span class="watchlist-remove-icon" data-movieid="<?= $movie['movieid'] ?>">&times;</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
                <p>Your watchlist is empty.</p>
            <?php endif; ?>
        </div>
        <div id="watchhistory" class="tab-content">
    <h2>Watch History</h2>
    <p>Keep track of the movies you've watched. Revisit your viewing history anytime!</p>
    <?php if (!empty($watchHistory)): ?>
        <ul class="watchhistory-list">
            <?php foreach ($watchHistory as $movie): ?>
                <li id="movie-<?= $movie['movieid'] ?>" class="movie-history-item">
                    <a href="/movie/<?= urlencode($movie['moviename']); ?>">
                        <?= htmlspecialchars($movie['moviename']); ?>
                    </a>
                    <span class="remove-icon" data-movieid="<?= $movie['movieid'] ?>">&times;</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
                <p>Your watch history is empty.</p>
            <?php endif; ?>
        </div>

        <div id="reviews" class="tab-content">
            <!-- Content for Reviews Made -->
            <h2>My Reviews</h2>
            <?php if (!empty($userReviews)): ?>
                <ul>
                    <?php foreach ($userReviews as $review): ?>
                        <li>
                            <a href="/movie/<?= isset($review['moviename']) ? urlencode($review['moviename']) : 'unknown'; ?>#review-<?= isset($review['reviewid']) ? $review['reviewid'] : 'unknown'; ?>">
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
                
                <div class="form-group button-wrapper">
    <button type="submit">Update Profile</button>
</div>
            </form>
            <hr>
<div class="delete-account-section">
    <form action="/deleteaccount" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete your account? This cannot be undone.');">
        <input type="hidden" name="userid" value="<?= $_SESSION['userid'] ?>">
        <button type="submit" class="delete-button">Delete Account</button>
    </form>
</div>
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
  <script>
document.querySelectorAll('.remove-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        const movieid = this.getAttribute('data-movieid');

        fetch(`/remove-from-watchhistory/${movieid}`, {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById(`movie-${movieid}`).remove();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(err => console.error('Fetch error:', err));
    });
});
</script>

<script>
document.querySelectorAll('.watchlist-remove-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        const movieid = this.getAttribute('data-movieid');

        fetch(`/remove-from-watchlist/${movieid}`, {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById(`watchlist-movie-${movieid}`).remove();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(err => console.error('Fetch error:', err));
    });
});
</script>



    <footer>
        <?php include "inc/footer.inc.php"; ?>
    </footer>
</body>
</html>