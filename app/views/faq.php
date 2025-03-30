<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="/public/css/faq.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & FAQ - PeopleReviewMovies</title>
</head>
<body>

    <?php include "inc/header.inc.php"; ?>

    <main class="container">
        <h1>Frequently Asked Questions</h1>

        <!-- Accordion FAQ Section -->
        <div class="faq">
            <div class="faq-item">
                <h3 class="faq-question">How do I write a movie review?</h3>
                <div class="faq-answer">
                    <p>To write a movie review, simply search for the movie you're interested in, click on it, and scroll down to the reviews section where you can add your thoughts and ratings. Once done, click "Submit Review".</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">Can I edit or delete my review after submission?</h3>
                <div class="faq-answer">
                    <p>Yes! You can edit or delete your review by visiting the movie page and clicking on the "Edit" or "Delete" icon next to your review.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How are movie ratings calculated?</h3>
                <div class="faq-answer">
                    <p>Movie ratings are based on user submissions. You can rate a movie from 1 to 5 stars. The overall score is an average of all user ratings for that movie.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do I find the best movies to watch?</h3>
                <div class="faq-answer">
                    <p>You can check out the "Trending" section for popular and highly rated films.</p>
                </div>
            </div>

            <!-- <div class="faq-item">
                <h3 class="faq-question">How can I report inappropriate reviews?</h3>
                <div class="faq-answer">
                    <p>If you come across an inappropriate review, you can report it by clicking the "Report" button next to the review. Our moderation team will review the report and take necessary action.</p>
                </div>
            </div> -->

            <div class="faq-item">
                <h3 class="faq-question">How do I edit my profile information?</h3>
                <div class="faq-answer">
                    <p>You can update your profile by going to "My Account" then click "Edit Profile". From there, you can update your username, email.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">Can I rate a movie multiple times?</h3>
                <div class="faq-answer">
                    <p>Yes, you can only rate a same movie multiple times and you can update your review if you change your opinion after rewatching the movie.</p>
                </div>
            </div>
        </div>

        <div class="contact-section">
    <div class="contact-icon">
        <span>&#x2709;</span> <!-- Envelope icon -->
    </div>
    <div class="contact-text">
        <p><strong>CAN'T FIND WHAT YOU'RE LOOKING FOR?</strong></p>
        <p><a href="mailto:public@peoplereviewmovies.mail.sg">Contact us</a></p>
    </div>
</div>


        <!-- <p class="back-link"><a href="/app/views/home.php">Back to Home</a></p> -->
    </main>

    <?php include "inc/footer.inc.php"; ?>

    <script src="/public/javascript/faq.js"></script>
</body>
</html>
