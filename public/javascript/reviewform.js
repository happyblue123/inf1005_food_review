document.addEventListener("DOMContentLoaded", function () {
    // Modal and Confirmation Modal elements
    const modal = document.getElementById("review-modal");
    const confirmationModal = document.getElementById("confirmation-modal");
    const closeModalButtons = document.querySelectorAll(".close");
    
    // Buttons for New Review, Edit, and Delete
    const newReviewButton = document.querySelector(".new_review");
    const editButtons = document.querySelectorAll(".edit_button");
    const deleteButtons = document.querySelectorAll(".delete_button");
    
    // Form and input elements
    const reviewForm = document.querySelector("form");
    const reviewIdInput = document.getElementById("review-id");
    const reviewTextArea = document.getElementById("review-text");
    const ratingValueInput = document.getElementById("rating-value");
    const submitButton = document.getElementById("submit-button");
    
    // Star rating elements
    const stars = document.querySelectorAll("#rating i");
    
    let selectedRating = 0; // Store selected rating
    let reviewToDeleteId = null; // Review ID to delete
    
    // Initialize star rating functionality
    if (stars.length > 0 && ratingValueInput) {
        stars.forEach((star, index) => {
            // Hover effect
            star.addEventListener("mouseover", () => highlightStars(index));
            
            // Reset hover effect
            star.addEventListener("mouseout", () => highlightStars(selectedRating - 1));
            
            // Click to select rating
            star.addEventListener("click", () => {
                selectedRating = index + 1;
                ratingValueInput.value = selectedRating;
                highlightStars(index);
            });
        });
    }
    
    function highlightStars(index) {
        stars.forEach((s, i) => s.classList.toggle("selected", i <= index));
    }
    
    // Show modal for new review
    newReviewButton.addEventListener("click", function () {
        modal.style.display = "flex";
        resetReviewForm();
        submitButton.textContent = "Submit Review";
    });
    
    // Show modal for editing a review
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            modal.style.display = "flex";
            
            const reviewDiv = button.closest(".each_review");
            const reviewId = reviewDiv.getAttribute("data-review-id");
            const reviewText = reviewDiv.querySelector(".review-text").textContent;
            const rating = parseInt(reviewDiv.querySelector(".review-rating").textContent, 10);
            
            reviewIdInput.value = reviewId;
            reviewTextArea.value = reviewText;
            ratingValueInput.value = rating;
            selectedRating = rating;
            highlightStars(rating - 1);
            submitButton.textContent = "Update Review";
        });
    });
    
    // Show confirmation modal when delete button is clicked
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            reviewToDeleteId = button.closest(".each_review").getAttribute("data-review-id");
            confirmationModal.style.display = "flex";
        });
    });
    
    // Close modal when clicking the close button
    closeModalButtons.forEach(closeBtn => {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none"; // Hide the review modal
            confirmationModal.style.display = "none"; // Hide the confirmation modal
        });
    });
    
    // Close modal if clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
        if (event.target === confirmationModal) {
            confirmationModal.style.display = "none";
        }
    });
    
    // Handle confirm delete action
    document.getElementById("confirm-delete").addEventListener("click", function () {
        if (reviewToDeleteId) {
            // Redirect to the ReviewController (using a GET request)
            window.location.href = `/deleteReview/${reviewToDeleteId}`;
        }
    });
    
    // Handle cancel delete action
    document.getElementById("cancel-delete").addEventListener("click", function () {
        confirmationModal.style.display = "none";
    });
    
    // Helper function to reset review form
    function resetReviewForm() {
        reviewIdInput.value = "";
        reviewTextArea.value = "";
        ratingValueInput.value = "";
        selectedRating = 0;
        highlightStars(-1);
    }
});
