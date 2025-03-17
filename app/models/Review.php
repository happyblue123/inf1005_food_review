<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/Movie.php";

class Review {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    public function submitReview($userid, $movieid, $moviename, $rating, $user_review) {
        $movie = new Movie();
        $movie->verifyMovieinDB($movieid, $moviename);
        $stmt = $this->db->conn->prepare("INSERT INTO reviews (userid, movieid, rating, review_text, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$userid, $movieid, $rating, $user_review]);

    }
    
    public function fetchReviewData($movieid) {
        $stmt = $this->db->conn->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.userid = users.userid WHERE reviews.movieid = ?;");
        $stmt->execute([$movieid]);
        $allreviews = $stmt->fetchAll();

        return $allreviews;        
    }

    public function updateReview($review_id, $userid, $movieid, $rating, $user_review) {
        $movie = new Movie();
        $stmt = $this->db->conn->prepare("UPDATE reviews SET rating = ?, review_text = ?, created_at = NOW() WHERE reviewid = ? AND userid = ?");
        return $stmt->execute([$rating, $user_review, $review_id, $userid]);
    
    }
    
    public function deleteReviewById($reviewid) {
        $stmt = $this->db->conn->prepare("DELETE FROM reviews WHERE reviewid = ?");
        return $stmt->execute([$reviewid]);
    }
    
}
?>
