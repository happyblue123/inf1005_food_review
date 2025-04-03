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
    <link rel="stylesheet" href="/public/css/about.css">
    <script src="/public/javascript/about.js"></script>
    
    <title>About People Movie Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
    <!-- Navbar wrapper to control positioning -->
    <div class="navbar-container">
        <?php include "inc/header.inc.php"; ?>
    </div>

    <!-- Background parallax elements -->
    <div class="bg-parallax">
        <div class="bg-image bg-image-1" data-speed="0.03"></div>
        <div class="bg-image bg-image-2" data-speed="0.05"></div>
        <div class="bg-image bg-image-3" data-speed="0.02"></div>
        <div class="bg-image bg-image-4" data-speed="0.04"></div>
    </div>

    <div class="content">
    <!-- Header Section -->
    <div class="header">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <h2 class="mission-title">Our Mission</h2>
                    <h4 class="mission-description">
                        We provide honest, insightful, and engaging movie reviews to help viewers choose the best films to watch.
                    </h4>

                    <img src="/video/popcorn.gif" alt="Popcorn" class="popcorn-gif" />
                    <img src="/video/popcorn.gif" alt="Popcorn" class="popcorn-gif" />
                    <img src="/video/popcorn.gif" alt="Popcorn" class="popcorn-gif" />
                </div>
            </div>
        </div>
    </div>
</div>
        
        <!-- First content section -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-12">
                        <div class="reveal-text">
                            <h2>Core Values</h2>
                            <p>At PeopleMovieReview, we are committed to providing honest, unbiased reviews that our readers can trust. Our values are rooted in integrity, ensuring that every review is fair, transparent, and based on thoughtful analysis. We believe in the power of community, encouraging open discussions and diverse opinions from movie lovers around the world. Above all, we share a passion for movies, striving to explore and celebrate the art of filmmaking in all its forms. These values guide us as we continue to grow and connect with our audience, making sure every review and recommendation is a reflection of our commitment to quality and honesty.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="content">
    <div class="container">
        <h2 class="text-center mb-5">Meet the Team</h2>
        <div class="row">
            <!-- Team Member 1 -->
            <div class="col-12 col-sm-4 col-md-2 mb-4">
                <div class="team-member">
                    <img src="/Images/boy.png" alt="Quan Ren" class="img-fluid">
                    <div class="caption">
                        <h5>Quan Ren</h5>
                        <p>Frontend Developer</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 2 -->
            <div class="col-12 col-sm-4 col-md-2 mb-4">
                <div class="team-member">
                    <img src="/Images/gamer.png" alt="Ng Yong Xian" class="img-fluid">
                    <div class="caption">
                        <h5>Yong Xian</h5>
                        <p>Backend Developer</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 3 -->
            <div class="col-12 col-sm-4 col-md-2 mb-4">
                <div class="team-member">
                    <img src="/Images/girl.png" alt="Aishwarya Shri" class="img-fluid">
                    <div class="caption">
                        <h5>Aishwarya</h5>
                        <p>UI/UX Designer</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 4 -->
            <div class="col-12 col-sm-4 col-md-2 mb-4">
                <div class="team-member">
                    <img src="/Images/male.png" alt="Benson" class="img-fluid">
                    <div class="caption">
                        <h5>Benson</h5>
                        <p>Backend Developer</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 5 -->
            <div class="col-12 col-sm-4 col-md-2 mb-4">
                <div class="team-member">
                    <img src="/Images/bussiness-man.png" alt="Zhang Hui" class="img-fluid">
                    <div class="caption">
                        <h5>Zhang Hui</h5>
                        <p>UI/UX Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="content">
    <div class="container text-center">
        <h3>Contact Us</h3>
        <p>Have a question or concern? Feel free to contact us at <a href="mailto:public@peoplereviewmovies.mail.sg">public@peoplereviewmovies.mail.sg</a></p>
    
<p>For more help, check out <a href="/app/views/faq.php"><img src="/video/faq.gif" alt="FAQ GIF" style="width: 100px; height: auto;"/></a></p>

    </div>
</div>



<?php include "inc/footer.inc.php"; ?>
</body>
</html>