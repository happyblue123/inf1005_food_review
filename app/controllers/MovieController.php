<?php
class MovieController {
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2'; // Replace with your TMDb API key

    public function handleSearch($moviename) {
        $movieData = $this->fetchMovieData($moviename);
        // If movieData is not empty, only pass the first result to the view
        $movieData = $movieData ? [$movieData[0]] : [];
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
