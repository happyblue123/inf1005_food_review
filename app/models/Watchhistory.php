<?php
require_once __DIR__ . "/../core/Database.php";

class WatchHistory {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->conn;
    }

    public function addMovie($userid, $movieid, $moviename) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM watchhistory WHERE userid = ? AND movieid = ?");
            $stmt->execute([$userid, $movieid]);

            if ($stmt->fetchColumn() > 0) {
                return "exists";
            }

            $stmt = $this->conn->prepare("INSERT INTO watchhistory (userid, movieid, moviename) VALUES (?, ?, ?)");
            return $stmt->execute([$userid, $movieid, $moviename]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function removeMovie($userid, $movieid) {
        $stmt = $this->conn->prepare("DELETE FROM watchhistory WHERE userid = ? AND movieid = ?");
        $stmt->execute([$userid, $movieid]);
        return $stmt->rowCount() > 0;
    }

    public function isMovieInHistory($userid, $movieid) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM watchhistory WHERE userid = ? AND movieid = ?");
        $stmt->execute([$userid, $movieid]);
        return $stmt->fetchColumn() > 0;
    }

    public function getHistoryByUserId($userid) {
        $stmt = $this->conn->prepare("SELECT * FROM watchhistory WHERE userid = ?");
        $stmt->execute([$userid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteHistoryByUser($userid) {
        $stmt = $this->conn->prepare("DELETE FROM watchhistory WHERE userid = ?");
        $stmt->execute([$userid]);
    }

  
    public function getWatchHistoryByUserId($userid) {
        return $this->getHistoryByUserId($userid);
    }
}
?>
