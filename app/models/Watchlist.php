<?php
require_once __DIR__ . "/../core/Database.php";

class Watchlist {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->conn; // Use the existing connection from the Database class
    }

    public function addMovie($userid, $movieid, $moviename) {
        try {
            // Check if the entry already exists
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM watchlist WHERE userid = ? AND movieid = ?");
            $stmt->execute([$userid, $movieid]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                // Entry already exists, avoid duplicate insert
                return "exists";
            }

            // If not exists, insert the movie
            $stmt = $this->conn->prepare("INSERT INTO watchlist (userid, movieid, moviename) VALUES (?, ?, ?)");
            return $stmt->execute([$userid, $movieid, $moviename]);
        }
        catch (PDOException $e) {
            return false;
        }
    }

    public function removeMovie($userId, $movieId) {
        $stmt = $this->conn->prepare("DELETE FROM watchlist WHERE userid = ? AND movieid = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->rowCount() > 0;
    }

    public function isMovieInWatchlist($userId, $movieId) {
        $sql = "SELECT COUNT(*) FROM watchlist WHERE userid = ? AND movieid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $movieId]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getWatchlistByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM watchlist WHERE userid = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>