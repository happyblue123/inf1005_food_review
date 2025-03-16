<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']); // Check if the user is logged in

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
    } else {
        include "inc/header.inc.php";
    }
    ?>

    <div class="container">
        

    <div id="search-container">
        <h2>Movie Search</h2>
        <input type="text" id="movie-search" placeholder="Search for a movie...">
    </div>

    <div id='moviesearched'>
        <div class='movie-info'>
            <?php if (!empty($movieData)): ?>
                <h3><?php echo htmlspecialchars($movieData[0]['title']); ?></h3>
                <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movieData[0]['release_date']); ?></p>
                <p><strong>Overview:</strong> <?php echo htmlspecialchars($movieData[0]['overview']); ?></p>
                <?php if (isset($movieData[0]['poster_path'])): ?>
                    <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movieData[0]['poster_path']); ?>" alt="<?php echo htmlspecialchars($movieData[0]['title']); ?>">
                <?php endif; ?>

            <?php else: ?>
                <p>No movies found matching your search criteria.</p>
            <?php endif; ?>
        </div>
        <div class='movie-rating'>
            <p class='total-reviews'>Total reviews: <?php echo $totalReviews?></p>
            <p class='avg-rating'>Avg rating: <?php echo $averageRating?></p>
        </div>
    </div>
    
    <div id="reviews">
        <h2>Reviews</h2>
        <?php if ($totalReviews != 0): ?>
            <?php foreach ($reviewsData as $review): ?>
                <div class='each_review'>
                    <p>username: <?= $review['username'];?></p>
                    <p>rating: <?=$review['rating'];?></p>
                    <p><?=$review['review_text'];?></p>
                    <p><?=$review['created_at'];?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>
    
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); // Clear the message after displaying it ?>
    <?php endif; ?>


    <div id="form-review">
        <h2>Leave a review</h2>

        <form action="/submitReview" method="POST">
            <div>
                <label for="rating">Rating:</label>
                <div id="rating">
                    <!-- Star icons for rating (hoverable and clickable) -->
                    <i class="fa fa-star" data-index="0"></i>
                    <i class="fa fa-star" data-index="1"></i>
                    <i class="fa fa-star" data-index="2"></i>
                    <i class="fa fa-star" data-index="3"></i>
                    <i class="fa fa-star" data-index="4"></i>
                    <input type="hidden" name="rating" id="rating-value" value="">
                </div>
            </div>

            <div>
                <label for="review">Your Review:</label>
                <textarea name="review" id="review" rows="4" placeholder="Write your review here..."></textarea>
            </div>

            <button type="submit">Submit Review</button>
        </form>
    </div>



    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
