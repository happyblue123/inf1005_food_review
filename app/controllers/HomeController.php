<?php

require_once __DIR__ . '/../controllers/MovieController.php';
require_once __DIR__ . '/../models/Watchlist.php';

class HomeController {
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2';
    public function index() {
        // Create an instance of MovieController
        $movieController = new MovieController();
        
        // Fetch trending movies using MovieController
        $movieData = $movieController->fetchMovies();
        $genreList = $movieController->readGenres();
        $watchlist = [];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['userid'])) {
            return $watchlist;
        }

        
        $watchlistModel = new Watchlist();
        $watchlist = $watchlistModel->getWatchlistByUserId($_SESSION['userid']);
        foreach ($watchlist as $index => $movie) {  // Using pass-by-value (no reference)
            $url = "https://api.themoviedb.org/3/movie/{$movie['movieid']}?api_key={$this->apiKey}&language=en-US";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)
        
            $response = curl_exec($ch);
            curl_close($ch);
        
            $data = json_decode($response, true);  // Decode the JSON response into an associative array
        
            // Check if poster_path is available
            if (isset($data['poster_path'])) {
                $watchlist[$index]['poster_path'] = $data['poster_path'];  // Directly update the $watchlist element
            } else {
                $watchlist[$index]['poster_path'] = null;
            }
        }

        // Pass the data to the home view
        require_once __DIR__ . '/../views/home.php';
    }

    // Add this goodbye method
    public function goodbye() {
        // Display the goodbye page
        require_once __DIR__ . '/../views/goodbye.php';
    }
}