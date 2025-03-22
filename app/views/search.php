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
<link rel="stylesheet" href="/public/css/search.css">
<script src="/public/javascript/searchbar.js"></script>
<script src="/public/javascript/reviewform.js"></script>
<title>Result of Search</title>
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
    
    <main>  
        <div id="search-container">
            <h2>Movie Search</h2>
            <input type="text" id="movie-search" placeholder="Search for a movie...">
        </div>

        <div id='moviesearched'>
            <div class='movie-info'>
                <?php if (!empty($movieData)): ?> <!-- if queried movie is found then display the info -->
                    <h3><?php echo htmlspecialchars($movieData[0]['title']); ?></h3>
                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movieData[0]['release_date']); ?></p>
                    <p><strong>Overview:</strong> <?php echo htmlspecialchars($movieData[0]['overview']); ?></p>
                    <?php if (isset($movieData[0]['poster_path'])): ?>
                        <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movieData[0]['poster_path']); ?>" alt="<?php echo htmlspecialchars($movieData[0]['title']); ?>">
                    <?php endif; ?>
                    <div class='movie-rating'>
                        <p class='total-reviews'>Total reviews: <?php echo $totalReviews?></p>
                        <p class='avg-rating'>Avg rating: <?php echo $averageRating?></p>
                    </div>
                <?php else: ?>
                    <p>No movies found matching your search criteria.</p>
                <?php endif; ?>
            </div>
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


            <?php if ($totalReviews != 0): ?>
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
                        <p class="review-rating"><?= $review['rating']; ?></p>
                        <p class="review-text"><?= $review['review_text']; ?></p>
                        <p><?= $review['created_at']; ?></p>

                        <?php if (isset($_SESSION['userid']) && $review['userid'] == $_SESSION['userid']): ?>
                            <div class="edit_delete_buttons">
                                <button class="edit_button">Edit</button>
                                <button class="delete_button">Delete</button>
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
