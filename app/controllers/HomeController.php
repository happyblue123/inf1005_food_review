<?php

require_once __DIR__ . '/../controllers/MovieController.php';
require_once __DIR__ . '/../models/Watchlist.php';

class HomeController {
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

        // Pass the data to the home view
        require_once __DIR__ . '/../views/home.php';
    }

    // Add this goodbye method
    public function goodbye() {
        // Display the goodbye page
        require_once __DIR__ . '/../views/goodbye.php';
    }
}