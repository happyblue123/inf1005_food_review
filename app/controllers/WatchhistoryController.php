<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Watchhistory.php';
require_once __DIR__ . '/../models/Movie.php';

class WatchHistoryController {

    public function saveMovieToHistory($fullRoute, $param) {
        if (!isset($_SESSION['userid'])) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Please login to mark movies as watched."]);
            exit;
        }

        $movieId = explode('&', $param)[0];
        $moviename = urldecode(explode('&', $param)[1]);

        $movie = new Movie();
        $movie->verifyMovieinDB($movieId, $moviename); // Ensure movie exists in DB

        $history = new WatchHistory();
        $result = $history->addMovie($_SESSION['userid'], $movieId, $moviename);

        if ($result === "exists") {
            echo json_encode(["status" => "error", "message" => "Already marked as watched."]);
        } else if ($result === false) {
            echo json_encode(["status" => "error", "message" => "Error adding to history."]);
        } else {
            echo json_encode(["status" => "success", "message" => "Added to watch history."]);
        }
    }

    public function removeMovieFromHistory($fullRoute, $param) {
        if (!isset($_SESSION['userid'])) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Please login to remove movies from watch history."]);
            exit;
        }

        $movieId = explode('&', $param)[0];
        $moviename = urldecode(explode('&', $param)[1]);

        $history = new WatchHistory();
        $result = $history->removeMovie($_SESSION['userid'], $movieId);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "Removed from watch history."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error removing from history."]);
        }
    }
}
?>
