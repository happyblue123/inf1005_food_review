<?php

require_once __DIR__ . "/../models/Review.php";
require_once __DIR__ . "/../models/Watchlist.php";

class MovieController {
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2'; // Replace with your TMDb API key

    private function fetchMoviesByGenre($genre_id, $page_id) {
        $url = "https://api.themoviedb.org/3/discover/movie?api_key=" . $this->apiKey . "&with_genres=" . $genre_id . "&page=" . $page_id;
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)

        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the response is valid
        if ($response === FALSE) {
            return null;
        }

        $data = json_decode($response, true);
        if (empty($data['results'])) {
            return [];
        }
        else {
            return $data['results'];
        } 
    }

    public function readGenres() {
        $genrelist_file = $_SERVER['DOCUMENT_ROOT'] . '/public/json/genrelist.json';
        $jsonData = file_get_contents($genrelist_file);
        $genreList = json_decode($jsonData, true)['genres'];
        return $genreList;
    }

    public function handleSearch($fullRoute, $param) {
        

        // info to populate side panel - genre
        $genreList = $this->readGenres();
        
        $queried_parts = explode("/", $fullRoute);
        $route_to = $queried_parts[1];
        $search_by = $queried_parts[2];
        $formattedReviews = [];
        
        if (strpos($param, '?') === false) { // ensure ?page exist before using explode
            $userinput = $param;
            $page_id = 1; // default page   
        }
        else {
            $userinput = explode("?", $param)[0];
            $page_param = explode("?", $param)[1]; // pageparam is page=1;
            $page_id = explode("=", $page_param)[1];
        }
     
        if ($route_to === "movie") {
            $movie_name = $userinput;
            $movieData = $this->fetchMovieDataByName($movie_name, $route_to, 1); // page is always 1 since there is only 1 result
        }
        else if ($route_to === "search") {
            if ($search_by === "genre") {
                $index = array_search($userinput, array_column($genreList, 'name'));
                if ($index === false) {
                    $movieData = []; // no such genre
                }
                else {
                    $genre_id = $genreList[$index]['id'];
                    $movieData = $this->fetchMoviesByGenre($genre_id, $page_id);
                }
            }       
            else if ($search_by === "query") {
                $movie_name = $userinput;
                $movieData = $this->fetchMovieDataByName($movie_name, $route_to, $page_id);
            }
        }
            
        if (!empty($movieData)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            foreach ($movieData as &$movie) {
                $review = new Review();
                $movieid = $movie['id'];
                $totalReviews = 0;
                $averageRating = 0;
                $reviewsData = $review->fetchReviewData($movieid);
                usort($reviewsData, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']); // Sort the reviews by date, newest first
                });
                // format the results fetched from db reviews table
                foreach ($reviewsData as $review) {
                    $totalReviews++;
                    $averageRating += $review['rating'];

                    $formattedReviews[] = [
                        'userid'    => $review['userid'],
                        'reviewid'    => $review['reviewid'],
                        'username'    => $review['username'],
                        'rating'      => $review['rating'],
                        'review_text' => $review['review_text'],
                        'created_at'  => date('d M Y, H:i:s', strtotime($review['created_at']))
                    ];
                }
                if ($totalReviews > 0) {
                    $averageRating /= $totalReviews;
                    $averageRating = number_format($averageRating, 2);
                } 
                else {
                    $averageRating = 0;  // In case there are no reviews, set the average to 0
                }
                $movie['rating'] = $averageRating;
                $movie['total-reviews'] = $totalReviews;
            }
            
            
        }

        if ($route_to === 'movie') {
            $watchlist = new Watchlist();
            if (isset($_SESSION['userid'])) {
                $isInWatchlist = $watchlist->isMovieInWatchlist($_SESSION['userid'], $movieData[0]['id']);
            }
            require_once __DIR__ . '/../views/movie.php';
        } 
        elseif ($route_to === 'search') {
            require_once __DIR__ . '/../views/search.php';
        }
    }

    private function fetchMovieDataByName($moviename, $route_to, $page_id) {
        $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $this->apiKey . '&query=' . urlencode($moviename) . "&page=" . $page_id;

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)

        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the response is valid
        if ($response === FALSE) {
            return null;
        }

        $moviename = urldecode($moviename);

        $data = json_decode($response, true);

        if ($route_to === "movie") {
            // Loop through the results and check if the title matches the searched movie name
            foreach ($data['results'] ?? [] as $movie) {
                if (strtolower($movie['title']) === strtolower($moviename)) {
                    return [$movie]; // only return the movie if the route is to /movie
                }
            }
        }
        else if ($route_to === "search") {
            return $data['results']; // return all movies that matched the query
        }
    }

    public function fetchMovies() {

        $urls = [
            'trending' => 'https://api.themoviedb.org/3/trending/movie/day?api_key=' . $this->apiKey,
            'now_playing' => 'https://api.themoviedb.org/3/movie/now_playing?api_key=' . $this->apiKey,
            'upcoming' => 'https://api.themoviedb.org/3/movie/upcoming?api_key=' . $this->apiKey
        ];

        $movies = [];

        foreach ($urls as $key => $url) {
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Optional: Disable SSL verification
            
            $response = curl_exec($ch);
            curl_close($ch);
        
            // Check if request was successful
            if ($response !== FALSE) {
                $data = json_decode($response, true);
                
                if (isset($data['results']) && !empty($data['results'])) {
                    $movies[$key] = $data['results'];
                } 
                else {
                    $movies[$key] = [];  // Empty array if no results found
                }
            } 
            else {
                $movies[$key] = [];  // Handle cURL failure
            }
        }
        return $movies;
    }

}

?>
