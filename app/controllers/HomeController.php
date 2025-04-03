<?php

require_once __DIR__ . '/../controllers/MovieController.php';

class HomeController {
    public function index() {
        // Create an instance of MovieController
        $movieController = new MovieController();
        
        // Fetch trending movies using MovieController
        $movieData = $movieController->fetchMovies();
        $genreList = $movieController->readGenres();
        
        // Pass the data to the home view
        require_once __DIR__ . '/../views/home.php';
    }
}

?>

