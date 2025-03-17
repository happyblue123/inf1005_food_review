<?php

require_once __DIR__ . "/../models/Review.php";

class MovieController {
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2'; // Replace with your TMDb API key

    public function handleSearch($moviename) {
        $movieData = $this->fetchMovieData($moviename);
        $totalReviews = 0;
        $averageRating = 0;
        if (!empty($movieData)) {
            $review = new Review();
            $movieid = $movieData[0]['id'];
            $reviewsData = $review->fetchReviewData($movieid);

            usort($reviewsData, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']); // Newest first
            });
            
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
                $averageRating /= $totalReviews;  // Get the average by dividing the sum of ratings by total reviews
                $averageRating = number_format($averageRating, 2);
            } else {
                $averageRating = 0;  // In case there are no reviews, set the average to 0
            }
        }
        // // If movieData is not empty, only pass the first result to the view
        // $movieData = $movieData ? [$movieData[0]] : [];
        require_once __DIR__ . '/../views/search.php';
    }

    private function fetchMovieData($moviename) {
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
        // Loop through the results and check if the title matches the given movie name
        foreach ($data['results'] ?? [] as $movie) {
            if (strtolower($movie['title']) === strtolower($moviename)) {
                return [$movie];  // Return the matching movie
            }
        }

        return [];
    }

    public function fetchTrendingMovies() {
        $url = 'https://api.themoviedb.org/3/trending/movie/day?api_key=' . $this->apiKey;
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)
        
        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the request was successful
        if ($response === FALSE) {
            return [];
        }
        
        // Decode the JSON response
        $data = json_decode($response, true);
        // Check if the 'results' key exists and return the movies
        if (isset($data['results']) && !empty($data['results'])) {
            return $data['results'];
        } else {
            return [];  // Return empty if no results are found
        }
        
    }

}

?>
