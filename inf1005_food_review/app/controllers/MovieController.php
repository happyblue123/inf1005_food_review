<?php

require_once __DIR__ . "/../models/Review.php";

class MovieController {
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2'; // Replace with your TMDb API key

    public function handleSearch($moviename) {
        $movieData = $this->fetchMovieDataByName($moviename);
        $totalReviews = 0;
        $averageRating = 0;
        if (!empty($movieData)) {
            $review = new Review();
            $movieid = $movieData[0]['id'];
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
                    'created_at'  => $review['created_at']
                ];
            }

            if ($totalReviews > 0) {
                $averageRating /= $totalReviews;
                $averageRating = number_format($averageRating, 2);
            } 
            else {
                $averageRating = 0;  // In case there are no reviews, set the average to 0
            }
        }
        require_once __DIR__ . '/../views/search.php';
    }

    private function fetchMovieDataByName($moviename) {
        $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $this->apiKey . '&query=' . urlencode($moviename);

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
        // Loop through the results and check if the title matches the searched movie name
        foreach ($data['results'] ?? [] as $movie) {
            if (strtolower($movie['title']) === strtolower($moviename)) {
                return [$movie];
            }
        }

        return [];
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
