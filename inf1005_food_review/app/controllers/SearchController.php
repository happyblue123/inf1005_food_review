<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Watchlist.php';

class SearchController {
    // ...existing code...

    public function saveMovieToWatchlist() {
        if (!isset($_SESSION['userid'])) {
            echo "Please login to add movies to your watchlist.";
            http_response_code(401);
            exit();
        }

        $movieId = $_POST['movieid'];
        $moviename = $_POST['moviename'];

        $watchlist = new Watchlist();
        $result = $watchlist->addMovie($_SESSION['userid'], $movieId, $moviename);

        if ($result) {
            echo "Movie added to watchlist!";
        } else {
            echo "Failed to add movie to watchlist.";
            http_response_code(500);
        }
    }
}
?>