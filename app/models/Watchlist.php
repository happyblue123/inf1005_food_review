<?php
require_once __DIR__ . "/../core/Database.php";

class Watchlist {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    public function addMovie($userid, $movieid, $moviename) {
        try {
            // Check if the entry already exists
            $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM watchlist WHERE userid = ? AND movieid = ?");
            $stmt->execute([$userid, $movieid]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                // Entry already exists, avoid duplicate insert
                return "exists";
            }

            // If not exists, insert the movie
            $stmt = $this->db->conn->prepare("INSERT INTO watchlist (userid, movieid, moviename) VALUES (?, ?, ?)");
            return $stmt->execute([$userid, $movieid, $moviename]);
        }
        catch (PDOException $e) {
            return false;
        }
        
    }

    public function getWatchlistByUserId($userId) {
        $stmt = $this->db->conn->prepare("SELECT * FROM watchlist WHERE userid = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>