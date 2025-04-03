<?php
require_once __DIR__ . "/../core/Database.php";

class Movie {
    private $db;
    private $apiKey = '6cf96494d2d88470ef456aa5cf938cf2';
    public function __construct() {
        $this->db = new Database();
    }

    public function verifyMovieinDB($movieid, $moviename) {
        $stmt = $this->db->conn->prepare("SELECT * FROM movies WHERE movieid = ?");
        $stmt->execute([$movieid]);

        if ($stmt->rowCount() === 0) {
            // If movie is not found, insert it
            $this->insertMovie($movieid, $moviename);
        }
    }

    private function insertMovie($movieid, $moviename) {

        $url = "https://api.themoviedb.org/3/movie/{$movieid}?api_key={$this->apiKey}&language=en-US";
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $data = json_decode($response, true);  // Decode the JSON response into an associative array
    
        // Check if poster_path is available
        if (isset($data['poster_path'])) {
            $poster_path = $data['poster_path'];  // Directly update the $watchlist element
        } else {
            $poster_path = null;
        }

        $stmt = $this->db->conn->prepare("INSERT INTO movies (movieid, moviename, posterpath) VALUES (?, ?, ?)");
        $stmt->execute([$movieid, $moviename, $poster_path]);
    }
}
?>
