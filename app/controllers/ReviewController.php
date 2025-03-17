<?php
require_once __DIR__ . "/../models/Review.php";

class ReviewController {
    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $login = isset($_SESSION['userid']);
    
            if (!$login) {
                $_SESSION['message'] = "Please login to submit a review.";
                header('Location: /search/' . urlencode($_SESSION['moviename']));
                exit;
            }
    
            $userid = $_SESSION['userid'];
            $movieid = $_SESSION['movieid'];
            $moviename = $_SESSION['moviename'];
            $rating = (int) $_POST['rating'];
            $user_review = $_POST['review'];
    
            $error = false;
            $error_msg = "";
            if (empty($user_review)) {
                $error = true;
                $error_msg = "Review cannot be empty.";
            }
    
            if ($rating < 1 || $rating > 5) {
                $error = true;
                $error_msg = "Invalid rating. Please provide a rating between 1 and 5.";
            }
    
            if ($error) {
                $_SESSION['error_message'] = $error_msg;
                $_SESSION['error_display'] = true;
                header('Location: /search/' . urlencode($_SESSION['moviename']));
                exit;
            }
            
            $user_review = trim($user_review);                  // Remove leading/trailing whitespace
            $user_review = strip_tags($user_review, '<b><i>');  // Allow <b> and <i> tags only (if needed)
            $user_review = htmlspecialchars($user_review, ENT_QUOTES, 'UTF-8'); // Convert special characters for safe display


            $review = new Review();
    
            // Check if we're updating an existing review
            if (isset($_POST['review_id']) && !empty($_POST['review_id'])) {
                // Update review logic
                $reviewId = (int) $_POST['review_id'];
                $result = $review->updateReview($reviewId, $userid, $movieid, $rating, $user_review);
            } else {
                // New review submission logic
                $result = $review->submitReview($userid, $movieid, $moviename, $rating, $user_review);
            }
    
            // Redirect back to the search page after successful review submission or update
            header('Location: /search/' . urlencode($_SESSION['moviename']));
            exit;
        }
    
        // Load the search page after processing
        require_once __DIR__ . "/../views/search.php";
    }
    

    public function deleteReview($reviewId) {
        session_start();

        // Call the method to delete the review by ID
        $review = new Review();
        $result = $review->deleteReviewById($reviewId);
    
        // Redirect to the same page or wherever appropriate after deletion
        if ($result) {
            // Optionally, set a success message in the session
            $_SESSION['message'] = "Review deleted successfully!";
        } else {
            // Optionally, set an error message if something went wrong
            $_SESSION['error_message'] = "Failed to delete the review.";
        }
        header('Location: /search/' . urlencode($_SESSION['moviename']));
        exit();
    }
    
    
}
?>
