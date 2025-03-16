<?php
require_once __DIR__ . "/../core/Database.php";

class Movie {
    private $db;

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
        $stmt = $this->db->conn->prepare("INSERT INTO movies (movieid, moviename) VALUES (?, ?)");
        $stmt->execute([$movieid, $moviename]);
    }
}
?>
