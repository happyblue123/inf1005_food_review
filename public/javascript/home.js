document.addEventListener("DOMContentLoaded", function () {
  const textOptions = ["by fellow movie-goers.", "that show if it's worth watching.", "by normal people."];
  let index = 0;
  const textElement = document.getElementById("changing-text");

  function typeEffect(text, callback) {
    let i = 0;
    textElement.textContent = "";
    const interval = setInterval(() => {
      textElement.textContent += text[i];
      i++;
      if (i === text.length) {
        clearInterval(interval);
        // Wait 2 seconds before starting deletion
        setTimeout(() => deleteEffect(callback), 2000);
      }
    }, 100);
  }

  function deleteEffect(callback) {
    let text = textElement.textContent;
    let i = text.length;
    const interval = setInterval(() => {
      textElement.textContent = text.substring(0, i);
      i--;
      if (i < 0) {
        clearInterval(interval);
        // Wait 500ms before typing new text
        setTimeout(callback, 500);
      }
    }, 50);
  }

  function cycleText() {
    typeEffect(textOptions[index], () => {
      index = (index + 1) % textOptions.length;
      cycleText();
    });
  }

  cycleText(); // Start the typing animation
  
  // Get all carousels
  const carousels = document.querySelectorAll('.carousel');
    
  // Function to update carousel display based on screen size
  function updateCarouselDisplay() {
      const screenWidth = window.innerWidth;
      
      carousels.forEach(carousel => {
          const items = carousel.querySelectorAll('.carousel-item');
          
          // Reset all carousels to first slide when screen size changes significantly
          const activeItem = carousel.querySelector('.carousel-item.active');
          if (activeItem !== items[0]) {
              items.forEach(item => item.classList.remove('active'));
              items[0].classList.add('active');
          }
      });
  }
  
  // Add resize listener
  window.addEventListener('resize', updateCarouselDisplay);
  
  // Initial call
  updateCarouselDisplay();
  
});


