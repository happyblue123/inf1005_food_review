// Get all FAQ question elements
var faqQuestions = document.getElementsByClassName("faq-question");

// Loop through each FAQ question and add an event listener
for (var i = 0; i < faqQuestions.length; i++) {
    faqQuestions[i].addEventListener("click", function() {
        // Get the parent faq item
        var faqItem = this.parentElement;

        // If the clicked faq item is already active, toggle it (close it)
        if (faqItem.classList.contains("active")) {
            faqItem.classList.remove("active");
        } else {
            // If it's not active, remove "active" class from all faq items
            var allFaqItems = document.getElementsByClassName("faq-item");
            for (var j = 0; j < allFaqItems.length; j++) {
                allFaqItems[j].classList.remove("active");
            }
            // Add the "active" class to the clicked faq item to open it
            faqItem.classList.add("active");
        }
    });
}
