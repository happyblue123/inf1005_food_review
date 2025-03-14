<!DOCTYPE html>
<html lang="en">

<?php
    include "inc/head.inc.php"
?>

<body>
    <header class="text-white text-center">
        <h1>My Website</h1>
        <?php
            include "inc/header.inc.php"
        ?>
    </header>

    <!-- Video Background Section -->
    <div class="video-background fullscreen">
        <video autoplay muted loop id="bg-video" class="bg-video">
            <source src="/video/856399-hd_1920_1080_25fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="video-overlay">
            <h2>Looking for good food?</h2>
        </div>
    </div>

    <!-- New Section with Two Side-by-Side Divs -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <div class="image-gallery">
                    <img src="/images/pexels-ash-craig-122861-376464.jpg" class="img-fluid" alt="Gallery Image 1">
                    <img src="/images/pexels-evonics-1058277.jpg" class="img-fluid" alt="Gallery Image 2">
                    <img src="/images/pexels-janetrangdoan-1099680.jpg" class="img-fluid" alt="Gallery Image 3">
                    <img src="/images/pexels-life-of-pix-67468.jpg" class="img-fluid" alt="Gallery Image 4">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-grey">
                <h2 class="text-white">We help you find the best places to eat</h2>
            </div>
        </div>
    </div>

    <!-- New Flexbox Section -->
    <div class="container my-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center bg-blue-grey">
                <h2 class="text-white">How does it work?</h2>
            </div>
            <div class="col-12 my-3">
                <div class="video-background">
                    <video autoplay muted loop class="bg-video">
                        <source src="/video/register.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-overlay">
                        <p class="text-white">Step 1: Register</p>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="video-background">
                    <video autoplay muted loop class="bg-video">
                        <source src="/video/go to video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-overlay">
                        <p class="text-white">Step 2: Visit</p>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="video-background">
                    <video autoplay muted loop class="bg-video">
                        <source src="/video/eat video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-overlay">
                        <p class="text-white">Step 3: Eat</p>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="video-background">
                    <video autoplay muted loop class="bg-video">
                        <source src="/video/reivew video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-overlay">
                        <p class="text-white">Step 4: Write</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5">
        <h2>Welcome to My Website</h2>
        <p>This is a simple website template using Bootstrap.</p>
        <button class="btn btn-custom">Learn More</button>

        <section class="gallery mt-5">
            <h3>Image Gallery</h3>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 1">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 2">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 3">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 4">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 5">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="https://via.placeholder.com/350" class="img-fluid" alt="Gallery Image 6">
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
     <?php
     include "inc/footer.inc.php"
     ?>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/javascript/script.js"></script>
</body>
</html>