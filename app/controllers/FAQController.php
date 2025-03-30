<?php
class FAQController {
    // Method to show the FAQ page
    public function displayFAQ() {
        // Include the view for the privacy page
        require_once __DIR__ . '/../views/faq.php';
    }
}
?>
