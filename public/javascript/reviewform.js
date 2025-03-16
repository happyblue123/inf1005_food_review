document.addEventListener('DOMContentLoaded', function() {
    // Get all the star elements (i.e., <i> tags within #rating)
    const stars = document.querySelectorAll('#rating i');
    const ratingValueInput = document.getElementById('rating-value');  // Get the hidden input

    // Check if the rating value input exists
    if (ratingValueInput) {
        // Event listener for mouse hover (to show hover effect)
        stars.forEach(function(star, index) {
            star.addEventListener('mouseover', function() {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('hover');
                    } else {
                        s.classList.remove('hover');
                    }
                });
            });
        
            // Event listener for mouse leave (reset hover effect)
            star.addEventListener('mouseout', function() {
                stars.forEach(function(s) {
                    s.classList.remove('hover');
                });
            });
        
            // Event listener for click (to select rating)
            star.addEventListener('click', function() {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });

                // Save rating in the hidden input
                const rating = index + 1;
                ratingValueInput.value = rating;  // Set the value of the hidden input
            });
        });
    } else {
        console.error('Rating input field not found!');
    }
});
