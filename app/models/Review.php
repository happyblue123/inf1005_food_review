<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../models/Movie.php";

class Review {

    private $pdo;
    private $db;

    public function __construct() {
        $this->db = new Database(); // for raw access to conn if needed
        $this->pdo = $this->db->getConnection(); // cleaner PDO usage
    }

    public function submitReview($userid, $movieid, $moviename, $rating, $user_review) {
        $movie = new Movie();
        $movie->verifyMovieinDB($movieid, $moviename);

        $stmt = $this->pdo->prepare("INSERT INTO reviews (userid, movieid, moviename, rating, review_text, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$userid, $movieid, $moviename, $rating, $user_review]);
    }

    public function fetchReviewData($movieid) {
        $stmt = $this->pdo->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.userid = users.userid WHERE reviews.movieid = ?");
        $stmt->execute([$movieid]);
        return $stmt->fetchAll();
    }

    public function updateReview($review_id, $userid, $movieid, $moviename, $rating, $user_review) {
        $stmt = $this->pdo->prepare("UPDATE reviews SET rating = ?, review_text = ?, created_at = NOW() WHERE reviewid = ? AND userid = ?");
        return $stmt->execute([$rating, $user_review, $review_id, $userid]);
    }

    public function deleteReviewById($reviewid, $userid) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE reviewid = ? and userid = ?");
        $stmt->execute([$reviewid, $userid]);
        return $stmt->rowCount() > 0;
    }

    public function getReviewsByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE userid = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReviewsByUser($userid) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE userid = ?");
        $stmt->execute([$userid]);
    }
}
?>