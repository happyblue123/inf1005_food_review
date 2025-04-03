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
    <link rel="stylesheet" href="/public/css/privacy.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Statement - PeopleReviewMovies</title>
</head>
<body>

    <?php include "inc/header.inc.php"; ?>

    <main class="container">
        <h1>Privacy Statement</h1>
        <p>At <strong>PeopleReviewMovies</strong>, we value the privacy and security of your personal information. This Privacy Policy outlines how we collect, use, and protect your information when you visit our website or interact with our services. By using our services, you consent to the collection and use of information as described in this policy.</p>

        <h3>1. How We Collect Your Information</h3>
        <p>We collect personal information when you:</p>
        <ul>
            <li>Sign up to our site (e.g., name, email address, password).</li>
            <li>Submit reviews or rate movies.</li>
            <li>Contact customer support if you have any queries.</li>
        </ul>
        <p>We also collect non-personal data such as your browsing behavior to improve user experience and site performance.</p>

        <h3>2. How We Use Your Information</h3>
        <p>We may use your information for the following purposes:</p>
        <ul>
            <li>To provide services: Manage your account, allow you to submit reviews, and interact with other users.</li>
            <li>To personalize your experience: Recommend movies based on your ratings, interests, and preferences.</li>
            <li>To communicate with you: Send updates on new movie reviews, promotions, newsletters, and any changes to our terms and policies.</li>
            <li>To improve our site: Analyze user activity to enhance functionality and user experience.</li>
        </ul>
        <p>We do not sell or trade your personal information to third parties.</p>

        <h3>3. How We Protect Your Information</h3>
        <p>We implement security measures to protect your personal data, including encryption and secure access controls. However, no method of transmission over the internet is 100% secure. While we strive to protect your information, we cannot guarantee its absolute security.</p>

        <h3>4. Third-Party Services</h3>
        <p>We may share your information with trusted third-party partners for services such as:</p>
        <ul>
            <li>Analytics tools to analyze site traffic and user behavior.</li>
            <li>Social media platforms (if you link your account with them).</li>
        </ul>
        <p>These third parties are required to comply with applicable privacy laws and will not use your information for purposes outside of their service.</p>

        <h3>5. Your Rights Under GDPR (General Data Protection Regulation)</h3>
        <p>As a user, you have the following rights:</p>
        <ul>
            <li>The right to correction: You can update or correct any inaccurate information.</li>
            <li>The right to erasure: You can request that we delete your personal data (under certain conditions).</li>
        </ul>
       
        <h3>6. Cookies Policy</h3>
        <p>We use cookies to enhance your user experience by remembering your preferences and personalizing content. You can manage cookie settings in your browser.</p>

        <h3>7. Changes to This Privacy Policy</h3>
        <p>We may update this Privacy Policy periodically to reflect changes in our practices or legal requirements. We will notify you of significant changes via email or by posting a notice on our website. Please review this policy regularly to stay informed about how we are protecting your data.</p>

        <h1>Terms and Conditions</h1>
        <p>Effective Date: March 30, 2025</p>

        <p>By accessing or using the PeopleReviewMovies website, you agree to comply with and be bound by the following Terms and Conditions. If you do not agree with these terms, please do not use our website.</p>

        <h3>1. User Account</h3>
        <ul>
            <li>You must provide accurate and complete information when creating your account. You are responsible for maintaining the confidentiality of your login credentials.</li>
            <li>You agree to notify us immediately if you suspect any unauthorized use of your account.</li>
        </ul>

        <h3>2. User Conduct</h3>
        <p>You agree not to:</p>
        <ul>
            <li>Post inappropriate content, including offensive, harmful, or illegal material.</li>
            <li>Post false reviews or engage in fraudulent activities.</li>
            <li>Use the site to harass or discriminate against other users.</li>
            <li>Use any automated tools or scripts to access or scrape content from our website.</li>
        </ul>

        <h3>3. Content Ownership</h3>
        <p>All content on PeopleReviewMovies, including reviews, ratings, and graphics, is owned by us or our licensors. You may only use this content for personal, non-commercial purposes.</p>
        <p>By submitting reviews or content, you grant PeopleReviewMovies a royalty-free, perpetual license to display, distribute, and use that content.</p>

        <h3>4. Third-Party Links</h3>
        <p>Our website may contain links to third-party websites for additional resources or content. We are not responsible for the content or privacy practices of these external sites.</p>

        <h3>5. Disclaimers and Limitation of Liability</h3>
        <p>PeopleReviewMovies does not guarantee the accuracy or completeness of any movie reviews or user-generated content.</p>
        <p>We are not liable for any damages, including loss of data or personal injury, that arise from your use of our website.</p>

        <h3>6. Changes to Terms and Conditions</h3>
        <p>We reserve the right to update or change these Terms and Conditions at any time. We will notify you of significant changes by posting an updated version on the website.</p>

        <p class="back-link">
    <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '/home' ?>">Back</a>
</p>


    </main>

    <?php include "inc/footer.inc.php"; ?>

</body>
</html>
