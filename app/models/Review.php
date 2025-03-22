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
        // this is to check if our db have the movieid,
        //  if dont have it will insert the movie in parent table if not cannot insert review
        $movie->verifyMovieinDB($movieid, $moviename);
        $stmt = $this->db->conn->prepare("INSERT INTO reviews (userid, movieid, moviename, rating, review_text, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$userid, $movieid, $moviename, $rating, $user_review]);
    }
    
    public function fetchReviewData($movieid) {
        $stmt = $this->db->conn->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.userid = users.userid WHERE reviews.movieid = ?;");
        $stmt->execute([$movieid]);
        $allreviews = $stmt->fetchAll();

        return $allreviews;        
    }

    public function updateReview($review_id, $userid, $movieid, $moviename, $rating, $user_review) {
        $stmt = $this->db->conn->prepare("UPDATE reviews SET rating = ?, review_text = ?, created_at = NOW() WHERE reviewid = ? AND userid = ?");
        return $stmt->execute([$rating, $user_review, $review_id, $userid]);
    }
    
    public function deleteReviewById($reviewid, $userid) {
        $stmt = $this->db->conn->prepare("DELETE FROM reviews WHERE reviewid = ? and userid = ?");
        $stmt->execute([$reviewid, $userid]);
    
        if ($stmt->rowCount() > 0) {
            return true;
        } 
        else {
            return false;
        }
    }

    public function getReviewsByUserId($userId) {
        $stmt = $this->db->conn->prepare("SELECT * FROM reviews WHERE userid = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
