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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <title>Help & FAQ - PeopleReviewMovies</title> -->
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

            <div class="faq-item">
                <h3 class="faq-question">How can I see my past ratings and reviews?</h3>
                <div class="faq-answer">
                    <p>Absolutely! Head to your profile and select the “My Reviews” tab. There you’ll find a full list of all the reviews you’ve submitted, along with the rating and the movie titles.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do I edit my profile information?</h3>
                <div class="faq-answer">
                    <p>You can update your profile by going to "My Account" then click "Edit Profile". From there, you can update your username, email.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">Can I create a watchlist or add movies to favourites?</h3>
                <div class="faq-answer">
                    <p>Yes! You can add movies to your personal watchlist by clicking the “favourites" icon on any movie page. You can manage your entire list from your profile under the Watchlist tab.</p>
                </div>
            </div>

            <div class="faq-item">
    <h3 class="faq-question">How do I report a review?</h3>
    <div class="faq-answer">
        <p>If you come across a review that is inappropriate or violates our guidelines, you can report it by contacting us at <a href="mailto:public@peoplereviewmovies.mail.sg">public@peoplereviewmovies.mail.sg</a>. Our moderation team will review it and take appropriate action.</p>
    </div>
</div>

            <div class="faq-item">
    <h3 class="faq-question">What is Watch History and how does it work?</h3>
    <div class="faq-answer">
        <p>Watch History lets you keep track of movies you've seen. Just click the eye icon on any movie page to mark it as watched. You can view and manage your full watch history from your profile under the Watch History tab.</p>
    </div>
</div>

            <div class="faq-item">
                <h3 class="faq-question">Can I rate a movie multiple times?</h3>
                <div class="faq-answer">
                    <p>Yes, you can only rate a same movie multiple times and you can update your review if you change your opinion after rewatching the movie.</p>
                </div>
            </div>
        </div>
        <div class="faq-item">
    <h3 class="faq-question">Can I permanently delete my account?</h3>
    <div class="faq-answer">
        <p>Yes, you can permanently delete your account. Please note that once your account is deleted, all your data, including reviews and watchlist, <b>will be permanently removed</b> and <b>cannot be undone.</b></p>
        <p>If you wish to delete your account, you can do so from the Edit Profile section under your account settings.</p>
    </div>
</div>


<div class="contact-section">
    <div class="contact-icon">
        <span>&#x2709;</span> 
    </div>
    <div class="contact-text">
        <p><strong>CAN'T FIND WHAT YOU'RE LOOKING FOR?</strong></p>
        <p><a href="mailto:public@peoplereviewmovies.mail.sg">Contact us</a></p>
    </div>
</div>


       
    </main>

    <?php include "inc/footer.inc.php"; ?>

    <script src="/public/javascript/faq.js"></script>
</body>
</html>
