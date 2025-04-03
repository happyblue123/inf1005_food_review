<?php
require_once __DIR__ . "/../core/Database.php";

class Watchlist {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->conn; // Access the connection directly
    }

    // ✅ Add movie to watchlist (if not already there)
    public function addMovie($userid, $movieid, $moviename) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM watchlist WHERE userid = ? AND movieid = ?");
            $stmt->execute([$userid, $movieid]);

            if ($stmt->fetchColumn() > 0) {
                return "exists"; // Already in watchlist
            }

            $stmt = $this->conn->prepare("INSERT INTO watchlist (userid, movieid, moviename) VALUES (?, ?, ?)");
            return $stmt->execute([$userid, $movieid, $moviename]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ Remove movie from watchlist
    public function removeMovie($userId, $movieId) {
        $stmt = $this->conn->prepare("DELETE FROM watchlist WHERE userid = ? AND movieid = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->rowCount() > 0;
    }

    // ✅ Check if movie is already in user's watchlist
    public function isMovieInWatchlist($userId, $movieId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM watchlist WHERE userid = ? AND movieid = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetchColumn() > 0;
    }

    // ✅ Get all movies in a user's watchlist
    public function getWatchlistByUserId($userId) {
        $stmt = $this->conn->prepare("
            SELECT watchlist.userid, watchlist.movieid, watchlist.moviename, movies.posterpath
            FROM watchlist
            JOIN movies ON watchlist.movieid = movies.movieid
            WHERE watchlist.userid = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Delete all watchlist entries for a user (used in account deletion)
    public function deleteWatchlistByUser($userid) {
        $stmt = $this->conn->prepare("DELETE FROM watchlist WHERE userid = ?");
        $stmt->execute([$userid]);
    }
}
?>
