document.addEventListener("DOMContentLoaded", function () {
    let updateResult = document.querySelector(".update_result");
    if (updateResult) {
        updateResult.style.display = "block"; // Make it visible before animation starts

        setTimeout(() => {
            updateResult.style.opacity = "1";  // Smooth fade-in
            updateResult.style.transform = "translateY(0)"; // Move to normal position
        }, 50); // Small delay to trigger transition properly

        setTimeout(() => {
            updateResult.style.opacity = "0";  // Smooth fade-out
            updateResult.style.transform = "translateY(-10px)"; // Move up slightly

            setTimeout(() => {
                updateResult.style.display = "none"; // Hide completely after fading out
            }, 500); // Matches the transition duration
        }, 2000); // Visible for 2 seconds
    }
});
