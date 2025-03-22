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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <title>Trending Movies</title>
</head>
<body>
    <?php
    if ($login) {
        include "inc/headerwlogout.inc.php";
    } else {
        include "inc/header.inc.php";
    }
    ?>




    <!-- Background parallax elements -->
    <div class="bg-parallax">
        <div class="bg-image bg-image-1" data-speed="0.03"></div>
        <div class="bg-image bg-image-2" data-speed="0.05"></div>
        <div class="bg-image bg-image-3" data-speed="0.02"></div>
        <div class="bg-image bg-image-4" data-speed="0.04"></div>
    </div>

    <div class="container-fluid p-0">
        <!-- Header section -->
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10">
                        <h1>About Us</h1>
                        <h4>Our mission is simple: To show you the most ENJOYABLE movies to watch</h4>
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
                            <h2>Journey Through Space</h2>
                            <p>As you venture deeper into the cosmos, countless wonders await your discovery. The vast expanse of space holds secrets that have fascinated humanity since we first gazed at the stars.</p>
                            <p>This text appears with a smooth animation as you scroll past the first image, creating an engaging experience that draws you into the cosmic narrative.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Second content section -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-12">
                        <div class="reveal-text">
                            <h2>Nebulae and Star Formations</h2>
                            <p>Nebulae are cosmic nurseries where stars are born from clouds of gas and dust. These magnificent structures create some of the most beautiful sights in our universe.</p>
                            <p>Notice how each image moves at a different speed as you scroll, creating a sense of depth and dimension on your cosmic journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Third content section -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-12">
                        <div class="reveal-text">
                            <h2>The Infinite Beyond</h2>
                            <p>Beyond our solar system lie countless galaxies, each containing billions of stars. The scale of the universe is truly incomprehensible, making our exploration all the more humbling.</p>
                            <p>As you reach the end of this journey, consider how the parallax effect mirrors our understanding of space itself - layers upon layers of cosmic wonder, each moving at its own pace through the eternal dance of the universe.</p>
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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="team-member">
                            <img src="/Images/dev_pfp1.jpg" alt="Team Member 1" class="img-fluid">
                            <div class="caption">
                                <h5>John Doe</h5>
                                <p>Lead Developer</p>
                            </div>
                        </div>
                    </div>
                    <!-- Team Member 2 -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="team-member">
                            <img src="/Images/dev_pfp2.jpg" alt="Team Member 2" class="img-fluid">
                            <div class="caption">
                                <h5>Jane Smith</h5>
                                <p>UI/UX Designer</p>
                            </div>
                        </div>
                    </div>
                    <!-- Team Member 3 -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="team-member">
                            <img src="/Images/dev_pfp3.jpg" alt="Team Member 3" class="img-fluid">
                            <div class="caption">
                                <h5>Michael Brown</h5>
                                <p>Project Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>






<?php include "inc/footer.inc.php"; ?>
</body>
</html>