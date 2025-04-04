<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Watchlist.php';
require_once __DIR__ . '/../models/Movie.php';

class WatchlistController {

    public function saveMovieToWatchlist($fullRoute, $param) {
        header('Content-Type: application/json');
        if (!isset($_SESSION['userid'])) {
            
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Please login to add movies to your watchlist."]);
            exit;
        }
    
        $movieId = explode('&', $param)[0];
        $moviename = urldecode(explode('&', $param)[1]);
        $movie = new Movie();
        $movie->verifyMovieinDB($movieId, $moviename); 
    
        $watchlist = new Watchlist();
        $result = $watchlist->addMovie($_SESSION['userid'], $movieId, $moviename);
    
        if ($result === "exists") {
            echo json_encode(["status" => "error", "message" => "Already in watchlist!"]);
        } else if ($result === false) {
            echo json_encode(["status" => "error", "message" => "Error adding to watchlist."]);
        } else {
            echo json_encode(["status" => "success", "message" => "Added to watchlist."]);
        }
    }
    

    public function removeMovieFromWatchlist($fullRoute, $param) {
        if (!isset($_SESSION['userid'])) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Please login to remove movies from your watchlist."]);
            exit;
        }
    
        $movieId = explode('&', $param)[0];
        $watchlist = new Watchlist();
        $result = $watchlist->removeMovie($_SESSION['userid'], $movieId);
    
        if ($result) {
            echo json_encode(["status" => "success", "message" => "Removed from watchlist."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error removing from watchlist."]);
        }
    }
    
    
    
}
?>