<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);

if (isset($movieData[0]['title'])) {
    $_SESSION['moviename'] = $movieData[0]['title'];
}
if (isset($movieData[0]['id'])) {
    $_SESSION['movieid'] = $movieData[0]['id'];
}

require_once __DIR__ . '/../models/WatchHistory.php';
$watchHistory = new WatchHistory();
$isInHistory = $login ? $watchHistory->isMovieInHistory($_SESSION['userid'], $movieData[0]['id']) : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/public/css/movie.css">
    <link rel="stylesheet" href="/public/css/watchlist.css">
    <link rel="stylesheet" href="/public/css/watchhistory.css">
    <script src="/public/javascript/reviewform.js"></script>
    <script src="/public/javascript/watchlist.js"></script>
    <script src="/public/javascript/watchhistory.js"></script>
    <script src="/public/javascript/notification_review.js"></script>
</head>
<body>
    <?php include "inc/header.inc.php"; ?>

    <main> 
        <div id='moviesearched'>
            <?php if (!empty($movieData)): ?>
                <div class="movie-container">
                    <div class="movie-poster-container">
                        <?php if (isset($movieData[0]['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w342<?php echo htmlspecialchars($movieData[0]['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($movieData[0]['title']); ?>">
                        <?php endif; ?>
                    </div>

                    <div class="movie-details-container">
                        <div class="movie-main-info">
                            <div class="title-watchlist">
                                <h3><?php echo htmlspecialchars($movieData[0]['title']); ?></h3>

                                <!-- ❤️ Heart icon -->
                                <i class="watchlist-icon <?= $isInWatchlist ? 'fas fa-heart in-watchlist' : 'far fa-heart' ?>"
                                   data-movie-id="<?= $movieData[0]['id'] ?>"
                                   data-movie-name="<?= htmlspecialchars($movieData[0]['title'], ENT_QUOTES, 'UTF-8') ?>"
                                   data-in-watchlist="<?= $isInWatchlist ? 'true' : 'false' ?>"
                                   onclick="toggleWatchlist(this)">
                                </i>

                                <!-- 👁️ Eye icon -->
                                <img 
                                    src="<?= $isInHistory ? '/Images/eye.png' : '/Images/hidden.png' ?>" 
                                    alt="Toggle Watch History" 
                                    class="eye-icon"
                                    data-movie-id="<?= $movieData[0]['id'] ?>"
                                    data-movie-name="<?= htmlspecialchars($movieData[0]['title'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-in-history="<?= $isInHistory ? 'true' : 'false' ?>"
                                    onclick="toggleWatchHistory(this)"
                                    style="width: 20px; height: 20px; margin-left: 10px; cursor: pointer;"
                                >
                            </div>

                            <!-- Notification popup -->
                            <div id="notification-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;"></div>

                            <p><strong>Release Date:</strong> <?= htmlspecialchars($movieData[0]['release_date']); ?></p>
                            <p><strong>Overview:</strong> <?= htmlspecialchars($movieData[0]['overview']); ?></p>
                        </div>

                        <div class="movie-ratings-info">
                            <div class='movie-rating'>
                                <p class='total-reviews'>Total reviews: <?= $movieData[0]['total-reviews'] ?></p>
                                <p class='avg-rating'>Average rating: <?= $movieData[0]['rating'] ?>/5</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>No movies found matching your search criteria.</p>
            <?php endif; ?>
        </div>

        <div id="reviews">
            <h2>Reviews</h2>
            <?php if (isset($_SESSION['success_message'])): ?>
                <h4 class="update_result success"><?php echo $_SESSION['success_message']; ?></h4>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_display'])): ?>
                <h4 class="update_result error"><?php echo $_SESSION['error_message']; ?></h4>
                <?php unset($_SESSION['error_display'], $_SESSION['error_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['delete_result'])): ?>
                <h4 class="update_result success"><?php echo $_SESSION['delete_result']; ?></h4>
                <?php unset($_SESSION['delete_result']); ?>
            <?php endif; ?>

            <?php if ($login): ?>
                <button class="new_review">Click here to review</button>
            <?php else: ?>
                <button id="reviewLink">Click here to review</button>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        document.getElementById("reviewLink").addEventListener("click", function () {
                            let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
                            loginModal.show();
                        });
                    });
                </script>
            <?php endif; ?>

            <?php foreach ($formattedReviews as $review): ?>
                <div class="each_review" data-review-id="<?= $review['reviewid']; ?>">
                    <p class="review-username">
                        <?= $login && $review['userid'] == $_SESSION['userid'] ? '<strong>me</strong>' : htmlspecialchars($review['username']); ?>
                    </p>
                    <p class="review-rating">Rating: <?= $review['rating']; ?> / 5</p>
                    <p class="review-text"><?= $review['review_text']; ?></p>
                    <hr>
                    <p class="review-date"><?= $review['created_at']; ?></p>

                    <?php if ($login && $review['userid'] == $_SESSION['userid']): ?>
                        <div class="edit_delete_buttons">
                            <button class="edit_button"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="delete_button"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modals -->
        <div id="confirmation-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Are you sure you want to delete this review?</p>
                <button id="confirm-delete" data-review-id="">Confirm</button>
                <button id="cancel-delete">Cancel</button>
            </div>
        </div>

        <div id="review-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="/submitReview" method="POST">
                    <input type="hidden" name="review_id" id="review-id" value="">
                    <div id="rating">
                        <i class="fa fa-star" data-index="0"></i>
                        <i class="fa fa-star" data-index="1"></i>
                        <i class="fa fa-star" data-index="2"></i>
                        <i class="fa fa-star" data-index="3"></i>
                        <i class="fa fa-star" data-index="4"></i>
                        <input type="hidden" name="rating" id="rating-value" value="">
                    </div>
                    <label for="review-text">Your Review:</label>
                    <textarea required name="review" id="review-text" maxlength="500" rows="4" placeholder="Write your review here..."></textarea>
                    <button type="submit" id="submit-button">Submit Review</button>
                </form>
            </div>
        </div>
    </main>

    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
