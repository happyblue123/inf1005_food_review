<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/Movie.php";

class Review {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    public function submitReview($userid, $movieid, $moviename, $rating, $user_review) {
        // Ensure the movie exists in the database
        $movie = new Movie();
        $movie->verifyMovieinDB($movieid, $moviename);

        // Prepare SQL statement to insert the review
        $stmt = $this->db->conn->prepare("INSERT INTO reviews (userid, movieid, rating, review_text, created_at) VALUES (?, ?, ?, ?, NOW())");
        // Execute the statement using an array of values
        return $stmt->execute([$userid, $movieid, $rating, $user_review]);
    }
    
    public function fetchReviewData($movieid) {
        $stmt = $this->db->conn->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.userid = users.userid WHERE reviews.movieid = ?;");
        $stmt->execute([$movieid]);
        $allreviews = $stmt->fetchAll();

        return $allreviews;        
    }

    public function updateReview($review_id, $userid, $movieid, $rating, $user_review) {
        // Ensure the movie exists in the database
        $movie = new Movie();
    
        // Prepare SQL statement to update the review
        $stmt = $this->db->conn->prepare("UPDATE reviews SET rating = ?, review_text = ?, created_at = NOW() WHERE reviewid = ? AND userid = ?");
    
        // Execute the statement using an array of values
        return $stmt->execute([$rating, $user_review, $review_id, $userid]);
    }
    
    public function deleteReviewById($reviewid) {
        // Prepare SQL statement to delete the review
        $stmt = $this->db->conn->prepare("DELETE FROM reviews WHERE reviewid = ?");
        
        // Execute the statement with the review ID
        return $stmt->execute([$reviewid]);
    }
    

}
?>
