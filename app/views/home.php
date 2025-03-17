<?php
session_start();
$login = isset($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/public/css/home.css">
    <script src="/public/javascript/searchbar.js"></script>
    <script src="/public/javascript/fetchtrending.js"></script>
    <script src="/public/javascript/home.js"></script>
    <title>Trending Movies</title>
</head>
<body>
    <?php
    if ($login) {
        include "inc/headerwlogout.inc.php";
    } else {
        include "inc/header.inc.php";
    }
    ?>

<div class="video-container">
    <!-- Video Background -->
    <video autoplay muted loop>
        <source src="/video/home_page_video_bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Foreground Text -->
    <div class="content">
        <h2>Movie reivews <span id="changing-text"></span><span class="cursor">|</span></h2>
        <p class="gray-darker">Find the latest movie reviews and ratings here!</p>
    </div>
</div>




    <div class="container">
        

    <div id="search-container">
        <h2>Movie Search</h2>
        <input type="text" id="movie-search" name="movie_name" placeholder="Search for a movie..." required>
    </div>

    <div id='trending-movies'>
        <h2>Trending Movies</h2>
        <div id="trending-movie-container">
            <?php if (!empty($movieData)): ?>
                
                <?php foreach ($movieData as $movie): ?>
                    <div class="movie-item">
                        <a href="/search/<?php echo htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                            <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No trending movies found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
