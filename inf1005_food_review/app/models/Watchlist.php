<?php
require_once __DIR__ . "/../core/Database.php";

class Watchlist {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    public function addMovie($userId, $movieId, $moviename) {
        $stmt = $this->db->conn->prepare("INSERT INTO watchlist (userid, movieid, moviename, added_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $movieId, $moviename]);
    }

    public function getWatchlistByUserId($userId) {
        $stmt = $this->db->conn->prepare("SELECT * FROM watchlist WHERE userid = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>