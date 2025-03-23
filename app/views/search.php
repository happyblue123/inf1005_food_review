<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "inc/head.inc.php"; ?>
<link rel="stylesheet" href="/public/css/search.css">
<script src="/public/javascript/searchbar.js"></script>
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
        <!-- <div id="search-container">
            <input type="text" id="movie-search" placeholder="Search for a movie...">
        </div> -->
        <div id="main-content">
            <div id="side-panel">
                <h3>Genre</h3>
                <!-- Navigation-like panel with links for different genres -->
                <ul>
                    <li><a href="/search?genre=action">Action</a></li>
                    <li><a href="/search?genre=comedy">Comedy</a></li>
                    <li><a href="/search?genre=drama">Drama</a></li>
                    <!-- Add more genres as needed -->
                </ul>
            </div>

            <div id="result-container">
                <?php if (!empty($movieData)): ?> 
                    <?php foreach ($movieData as $movie) : ?>
                        <div class="movie-card">
                            <div class="movie-name">
                                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                            </div>
                            <div class="movie-content">
                                <?php if (isset($movie['poster_path'])): ?>
                                    <div class="movie-poster">
                                        <a href="/movie/<?php echo urlencode($movie['title']); ?>">
                                        <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                            alt="<?php echo htmlspecialchars($movie['title']); ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="movie-details">
                                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                                    <p><strong>Overview:</strong> <?php echo htmlspecialchars($movie['overview']); ?></p>
                                    <div class="movie-rating">
                                        <p class="total-reviews">Total Reviews: <?php echo $movie['total-reviews'] ?></p>
                                        <p class="avg-rating">
                                            Rating:
                                            <span class="stars">
                                                <?php 
                                                    $rating = round($movie['rating']); // Round to nearest integer (1 to 5 stars)
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        // Check if the current star should be filled
                                                        echo $i <= $rating ? '★' : '☆'; 
                                                    }
                                                ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No movies found matching your search criteria.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>



    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
