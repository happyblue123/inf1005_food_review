<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Watchlist.php';
require_once __DIR__ . '/../models/Movie.php';

class SearchController {

    public function saveMovieToWatchlist($fullRoute, $param) {
        if (!isset($_SESSION['userid'])) {
            // echo "Please login to add movies to your watchlist.";
            http_response_code(401);
            header('Location: /home');
            exit;
        }

        $movieId = explode('&', $param)[0];
        $moviename = urldecode(explode('&', $param)[1]);
        $movie = new Movie();
        $movie->verifyMovieinDB($movieId, $moviename); // if not in our db, it will be inserted
        
        $watchlist = new Watchlist();
        $result = $watchlist->addMovie($_SESSION['userid'], $movieId, $moviename);

        if ($result === "exists") {
            echo "already in watchlist!";
        } 
        else if ($result === false) {
            echo "error adding to watchlist";
        }
        else {
            echo "added to watchlist";
        }
    }
}
?>