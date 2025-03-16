<?php
require_once __DIR__ . "/../models/Review.php";

class ReviewController {
    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Start the session to access session variables
            session_start();
            // Check if the user is logged in (check if 'userid' is set in the session)
            $login = isset($_SESSION['userid']);
            
            // If the user is not logged in, show a login message
            if (!$login) {
                $message = "Please login to submit a review.";
                $_SESSION['message'] = $message;
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
            if(empty($user_review)) {
                $error = true;
            }

            if ($rating < 1 || $rating > 5) {
                $error = true;
            }

            if ($error) {
                $error_msg = "Error, please try again.";
                $_SESSION['message'] = $error_msg;
                header('Location: /search/' . urlencode($_SESSION['moviename']));
                exit;
            }

            $review = new Review();
            $result = $review->submitReview($userid, $movieid, $moviename, $rating, $user_review);
            header('Location: /search/' . urlencode($_SESSION['moviename']));
            exit;
        }
    
        // Load the search page after processing the request (whether the user is logged in or not)
        require_once __DIR__ . "/../views/search.php";
    }


    // public function fetchmyreviews() {
        
    //     require_once __DIR__ . "/../views/myreviews.php";
    // }    
    
}
?>
