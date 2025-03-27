<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);

// set moviename and movieid fetched from api through MovieController only if movie exists
if (isset($movieData[0]['title'])) {
    $_SESSION['moviename'] = $movieData[0]['title'];
}
if (isset($movieData[0]['id'])) {
    $_SESSION['movieid'] = $movieData[0]['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "inc/head.inc.php"; ?>
<link rel="stylesheet" href="/public/css/movie.css">
<link rel="stylesheet" href="/public/css/watchlist.css">
<script src="/public/javascript/searchbar.js"></script>
<script src="/public/javascript/reviewform.js"></script>
<script src="/public/javascript/watchlist.js"></script>
<title>Result of Search</title>
</head>
<body>
    <?php
    include "inc/header.inc.php";
    ?>
    
    <main>  
        <div id="search-container">
            <h2>Movie Search</h2>
            <input type="text" id="movie-search" placeholder="Search for a movie...">
        </div>

        <div id='moviesearched'>
            <?php if (!empty($movieData)): ?> <!-- if queried movie is found then display the info -->
                <div class="movie-container">
                    <!-- Left column: Movie poster -->
                    <div class="movie-poster-container">
                        <?php if (isset($movieData[0]['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w342<?php echo htmlspecialchars($movieData[0]['poster_path']); ?>" 
                                alt="<?php echo htmlspecialchars($movieData[0]['title']); ?>">
                        <?php endif; ?>
                    </div>
                    
                    <!-- Right column container -->
                    <div class="movie-details-container">
                        <!-- Top right: Title, release date, overview -->
                        <div class="movie-main-info">
                            <div class="title-watchlist">
                                <h3><?php echo htmlspecialchars($movieData[0]['title']); ?></h3>
                                <i class="watchlist-icon <?= $isInWatchlist ? 'fas fa-star in-watchlist' : 'far fa-star' ?>"
                                    data-movie-id="<?= $movieData[0]['id'] ?>"
                                    data-movie-name="<?= htmlspecialchars($movieData[0]['title'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-in-watchlist="<?= $isInWatchlist ? 'true' : 'false' ?>"
                                    onclick="toggleWatchlist(this)">
                                </i>
                            </div>
                            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movieData[0]['release_date']); ?></p>
                            <p><strong>Overview:</strong> <?php echo htmlspecialchars($movieData[0]['overview']); ?></p>
                        </div>
                        
                        <!-- Bottom right: Ratings and reviews count -->
                        <div class="movie-ratings-info">
                            <div class='movie-rating'>
                                <p class='total-reviews'>Total reviews: <?php echo $movieData[0]['total-reviews']?></p>
                                <p class='avg-rating'>Average rating: <?php echo $movieData[0]['rating']?>/5</p>
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
            <?php if(isset($_SESSION['error_display'])) : ?>
                <p style="color: red"><?php echo $_SESSION['error_message'];?></p>
                <?php
                unset($_SESSION['error_display']);
                unset($_SESSION['error_message']);
                ?>
            <?php endif ?>
            <?php if (isset($_SESSION['delete_result'])): ?>
                <h4 id="delete_result"><?php echo $_SESSION['delete_result']; ?></h4>
                <?php unset($_SESSION['delete_result']); ?>
            <?php endif ?>
            
            <?php if ($login): ?>
                <button class="new_review">Click here to review</button>
            <?php else: ?>
                <a href="javascript:void(0);" id="reviewLink">
                    <button class="">Click here to review</button>
                </a>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Add an event listener to the button
                        document.getElementById("reviewLink").addEventListener("click", function() {
                            // Create a Bootstrap modal instance and show it when the button is clicked
                            let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
                            loginModal.show();
                        });
                    });
                </script>
            <?php endif; ?>


            <?php if (!empty($movieData)): ?>
                <?php foreach ($reviewsData as $review): ?>
                    <div class="each_review" data-review-id="<?= $review['reviewid']; ?>">
                        <?php if ($login): ?>
                            <?php if ($review['userid'] == $_SESSION['userid']): ?>
                                <strong><p class="review-username">me</p></strong>
                            <?php else :  ?>
                                <p class="review-username"><?= $review['username']; ?></p>
                            <?php endif; ?>
                        <?php else :  ?>
                            <p class="review-username"><?= $review['username']; ?></p>
                        <?php endif; ?>
                        <p class="review-rating">Overall rating: <?= $review['rating']; ?></p>
                        <p class="review-text"><?= $review['review_text']; ?></p>
                        <p><?= $review['created_at']; ?></p>

                        <?php if (isset($_SESSION['userid']) && $review['userid'] == $_SESSION['userid']): ?>
                            <div class="edit_delete_buttons">
                                <button class="edit_button"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="delete_button"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    
    
        <!-- confirmation modal for deleting reviews -->
        <div id="confirmation-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Are you sure you want to delete this review?</p>
                <button id="confirm-delete" data-review-id="">Confirm</button>
                <button id="cancel-delete">Cancel</button>
            </div>
        </div>

        <!-- modal for submitting new review or editing review -->
        <div id="review-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <!-- Review form here -->
                <form action="/submitReview" method="POST">
                    <input type="hidden" name="review_id" id="review-id" value="">
                    <div>
                        <label for="rating">Rating:</label>
                        <div id="rating">
                            <i class="fa fa-star" data-index="0"></i>
                            <i class="fa fa-star" data-index="1"></i>
                            <i class="fa fa-star" data-index="2"></i>
                            <i class="fa fa-star" data-index="3"></i>
                            <i class="fa fa-star" data-index="4"></i>
                            <input type="hidden" name="rating" id="rating-value" value="" required>
                        </div>
                    </div>

                    <div>
                        <label for="review">Your Review:</label>
                        <textarea required name="review" id="review-text" maxlength="500" rows="4" placeholder="Write your review here..."></textarea>
                    </div>

                    <button type="submit" id="submit-button">Submit Review</button>
                </form>
            </div>
        </div>
    </main>


    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
