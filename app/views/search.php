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
</head>
<body>
    <?php
    include "inc/header.inc.php";
    ?>
    
    <main>
        <div id="main-content">
            <div id="side-panel"> <!-- Navigation-like panel with links for different genres -->
                <h3>Genre</h3>
                <ul>
                <?php foreach ($genreList as $genre): ?>
                    <li><a href="/search/genre/<?=urlencode($genre['name']); ?>"><?= htmlspecialchars($genre['name']); ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>

            <div id="result-container">
                <?php if (!empty($movieData)): ?>
                    <?php foreach ($movieData as $movie) : ?>
                        <div class="movie-card">
                            <div class="movie-name">
                                <a href="/movie/<?php echo urlencode($movie['title']); ?>">
                                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                </a>
                            </div>
                            <div class="movie-content">
                                <?php if (isset($movie['poster_path'])): http://35.212.143.101/?>
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
                    <p id='no-results'>NO RESULTS.</p>
                <?php endif; ?>

                <?php
                // Get current URL (excluding query parameters)
                $currentUrl = strtok($_SERVER["REQUEST_URI"], '?');

                // Get current page from the URL, default to 1 if not set
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                // Generate previous and next page numbers
                $prevPage = ($page > 1) ? $page - 1 : 1; // Prevent going below 1
                $nextPage = $page + 1;

                // Generate full URLs
                $prevUrl = $currentUrl . "?page=" . $prevPage;
                $nextUrl = $currentUrl . "?page=" . $nextPage;
                ?>
                <div class="pagination">
                    <a href="<?= $prevUrl; ?>" class="prev">← Prev</a>
                    <a href="<?= $nextUrl; ?>" class="next">Next →</a>
                </div>
            </div>
        </div>
    </main>



    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
