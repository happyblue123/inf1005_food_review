<?php

// Import necessary models
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Watchlist.php';

class UserController {

    // DELETE ACCOUNT LOGIC
    public function deleteAccount() {
        session_start();
        if (!isset($_SESSION['userid'])) {
            header("Location: /login");
            exit();
        }

        $userid = $_SESSION['userid'];

        // Clean up associated data (optional but good practice)
        $reviewModel = new Review();
        $reviewModel->deleteReviewsByUser($userid);

        $watchlistModel = new Watchlist();
        $watchlistModel->deleteWatchlistByUser($userid);

        $userModel = new User();
        $userModel->deleteUser($userid);

        session_destroy(); // End session
        header("Location: /goodbye"); // Redirect to goodbye or home
        exit();
    }
}