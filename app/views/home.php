<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);

require_once __DIR__ . '/../models/Watchlist.php';
// $watchlist = [];
// if ($login) {
//     $watchlistModel = new Watchlist();
//     $watchlist = $watchlistModel->getWatchlistByUserId($_SESSION['userid']);
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/public/css/home.css">
    <script src="/public/javascript/home.js"></script>
</head>
<body>
    <?php
    include "inc/header.inc.php";
    ?>

<!-- <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="gradient-sphere sphere-3"></div>
        <div class="glow"></div>
        <div class="grid-overlay"></div>
        <div class="noise-overlay"></div>
        <div class="particles-container" id="particles-container"></div>

</div> -->


    <div class="video-container">
        <!-- Video Background -->
        <video autoplay muted loop>
            <source src="/video/home_page_video_bg.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Foreground Text -->
        <div class="content">
            <h2>Movie reviews <span id="changing-text"></span><span class="cursor">|</span></h2>
            <p class="gray-darker">Find the latest movie reviews and ratings here!</p>
        </div>
    </div>

    <!-- <div id="search-container_home">
        <i class="fas fa-search"></i>
        <input class="form-control movie-search" type="text" name="movie_name" placeholder="Search for a movie..." required>
    </div> -->

    <div id="genres_list"> <!-- Navigation-like panel with links for different genres -->
        <ul>
        <?php foreach ($genreList as $genre): ?>
            <li><a href="/search/genre/<?=urlencode($genre['name']); ?>"><?= htmlspecialchars($genre['name']); ?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>
        

    <div class='each_row'>
        <h2>TRENDING</h2>
        <div id="trendingCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php if (!empty($movieData['trending'])): 
                    $slideCount = ceil(count($movieData['trending']) / 4);
                    for ($i = 0; $i < $slideCount; $i++): ?>
                        <button type="button" data-bs-target="#trendingCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                            <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $i+1; ?>"></button>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            
            <!-- Carousel content -->
            <div class="carousel-inner">
                <?php if (!empty($movieData['trending'])): 
                    $chunks = array_chunk($movieData['trending'], 4);
                    foreach ($chunks as $index => $movieChunk): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="d-flex justify-content-around">
                                <?php foreach($movieChunk as $movie): ?>
                                    <div class="movie-item">
                                        <a href="/movie/<?php echo urlencode($movie['title']); ?>">
                                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                            <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                                alt="<?php echo htmlspecialchars($movie['title']); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <p>Error fetching trending movies.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#trendingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#trendingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
        </div>
    </div>

    <div class='each_row'>
        <h2>NOW SHOWING</h2>
        <div id="nowPlayingCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php if (!empty($movieData['now_playing'])): 
                    $slideCount = ceil(count($movieData['now_playing']) / 4);
                    for ($i = 0; $i < $slideCount; $i++): ?>
                        <button type="button" data-bs-target="#nowPlayingCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                            <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $i+1; ?>"></button>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            
            <!-- Carousel content -->
            <div class="carousel-inner">
                <?php if (!empty($movieData['now_playing'])): 
                    $chunks = array_chunk($movieData['now_playing'], 4);
                    foreach ($chunks as $index => $movieChunk): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="d-flex justify-content-around">
                                <?php foreach($movieChunk as $movie): ?>
                                    <div class="movie-item">
                                        <a href="/movie/<?php echo urlencode($movie['title']); ?>">
                                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                            <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                                alt="<?php echo htmlspecialchars($movie['title']); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <p>Error fetching now playing movies.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#nowPlayingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#nowPlayingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class='each_row'>
        <h2>UPCOMING</h2>
        <div id="upcomingCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php if (!empty($movieData['upcoming'])): 
                    $slideCount = ceil(count($movieData['upcoming']) / 4);
                    for ($i = 0; $i < $slideCount; $i++): ?>
                        <button type="button" data-bs-target="#upcomingCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                            <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $i+1; ?>"></button>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            
            <!-- Carousel content -->
            <div class="carousel-inner">
                <?php if (!empty($movieData['upcoming'])): 
                    $chunks = array_chunk($movieData['upcoming'], 4);
                    foreach ($chunks as $index => $movieChunk): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="d-flex justify-content-around">
                                <?php foreach($movieChunk as $movie): ?>
                                    <div class="movie-item">
                                        <a href="/movie/<?php echo urlencode($movie['title']); ?>">
                                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                            <img src="https://image.tmdb.org/t/p/w200<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                                alt="<?php echo htmlspecialchars($movie['title']); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <p>Error fetching upcoming movies.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#upcomingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#upcomingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class='each_row'>
        <h2>YOUR WATCHLIST</h2>
        <?php if (!$login): ?>
            <div class="empty-watchlist-message text-center">
        <img src="/video/watchlist.gif" alt="Watchlist GIF" class="watchlist-gif" style="max-width: 100px; margin: 20px auto; display: block;">
        <p style="margin-top: 10px; font-weight: bold;">
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: inherit; text-decoration: underline;">Sign in</a>
            to access your Watchlist
        </p>
    </div>

        <?php else: ?>
            <div id="watchlistCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php if (!empty($watchlist)): 
                        $slideCount = ceil(count($watchlist) / 4);
                        for ($i = 0; $i < $slideCount; $i++): ?>
                            <button type="button" data-bs-target="#watchlistCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                                <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $i+1; ?>"></button>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>

                <div class="carousel-inner">
                    <?php if (!empty($watchlist)):
                        $chunks = array_chunk($watchlist, 4);
                        foreach ($chunks as $index => $movieChunk): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="d-flex justify-content-around">
                                    <?php foreach($movieChunk as $movie): ?>
                                        <div class="movie-item text-center mx-2 mb-4">
                                            <a href="/movie/<?= urlencode($movie['moviename']); ?>">
                                                <img src="https://image.tmdb.org/t/p/w200<?= urlencode($movie['posterpath'] ?? '/default.jpg'); ?>" 
                                                    alt="<?= htmlspecialchars($movie['moviename']); ?>" 
                                                    style="width: 150px; height: auto; border-radius: 8px;">
                                                <h4 style="margin-top: 10px; font-size: 16px;">
                                                    <?= htmlspecialchars($movie['moviename']); ?>
                                                </h4>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active empty-watchlist-message text-center">
                            <img src="/video/watchlist.gif" alt="Empty Watchlist" class="watchlist-gif" style="max-width: 200px; margin-bottom: 10px;">
                            <p><strong>Your Watchlist is empty</strong></p>
                            <p>Save movies to keep track of what you want to watch.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
                <?php if ($login): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#watchlistCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#watchlistCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
            <!--  -->
    </div>

    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
