<?php
require_once __DIR__ . "/../models/Review.php";

class ReviewController {
    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $login = isset($_SESSION['userid']);
    
            if (!$login) {
                $_SESSION['message'] = "Please login to submit a review.";
                header('Location: /movie/' . urlencode($_SESSION['moviename']));
                exit;
            }
    
            $userid = $_SESSION['userid'];
            $movieid = $_SESSION['movieid'];
            $moviename = $_SESSION['moviename'];
            $rating = (int) $_POST['rating'];
            $user_review = $_POST['review'];
    
            $error = false; // assume no error when submitting form
            $error_msg = "";

            // check for empty form
            if (empty($user_review)) {
                $error = true;
                $error_msg = "Review cannot be empty.";
            }
    
            if ($rating < 1 || $rating > 5) {
                $error = true;
                $error_msg = "Invalid rating. Please provide a rating between 1 and 5.";
            }
            
            // check if review text is more than max
            if (strlen($user_review) > 500) {
                $error = true;
                $error_msg = "Max char 500.";
            } 

            if ($error) {
                $_SESSION['error_message'] = $error_msg;
                $_SESSION['error_display'] = true;
                header('Location: /movie/' . urlencode($_SESSION['moviename']));
                exit;
            }
            
            // if form is not empty, perform input sanitization
            $user_review = trim($user_review);
            $user_review = strip_tags($user_review, '<b><i>');
            $user_review = htmlspecialchars($user_review, ENT_QUOTES, 'UTF-8');
            
            // to filter for vulgar words
            $url = "https://www.purgomalum.com/service/json?text=" . urlencode($user_review);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification (optional)
            curl_close($ch);
            $response = curl_exec($ch);
            $data = json_decode($response, true);
            $user_review = $data['result'];
            // error handling for purgomalum api
            if (isset($data['error'])) {
                $_SESSION['error_message'] = "Error submitting review!";
                $_SESSION['error_display'] = true;
                header('Location: /movie/' . urlencode($_SESSION['moviename']));
            }
            
            $review = new Review();
    
            // Check if action performed is to update an existing review
            if (isset($_POST['review_id']) && !empty($_POST['review_id'])) { // if there is a reviewid set
                $reviewId = (int) $_POST['review_id'];
                $result = $review->updateReview($reviewId, $userid, $movieid, $moviename, $rating, $user_review);
            } 
            else {
                $result = $review->submitReview($userid, $movieid, $moviename, $rating, $user_review);
            }
    
            header('Location: /movie/' . urlencode($moviename));
            exit;
        }
    
        require_once __DIR__ . "/../views/movie.php";
    }
    

    public function deleteReview($fullRoute) {
        session_start();
        $reviewId = explode("/", $fullRoute)[2]; // full route = /deleteReview/id, hence index 2 is the review id
        $userid = $_SESSION['userid'];
        
        $review = new Review();
        $result = $review->deleteReviewById($reviewId, $userid);
        if ($result) {
            $_SESSION['delete_result'] = "Review deleted successfully!";
        } 
        else {
            $_SESSION['delete_result'] = "Failed to delete the review.";
        }
        
        header('Location: /movie/' . urlencode($_SESSION['moviename']));
        exit();
    }
}
?>
