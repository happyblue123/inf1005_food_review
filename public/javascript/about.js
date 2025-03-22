// Parallax scrolling effect for main sections
function handleParallax() {
    const parallaxElements = document.querySelectorAll('.parallax-bg');
    const scrollTop = window.pageYOffset;
    
    parallaxElements.forEach(element => {
        const speed = element.getAttribute('data-speed');
        const offset = scrollTop * speed;
        element.style.transform = `translateY(${offset}px)`;
    });
}

// Background images parallax effect (medium speed)
function handleBackgroundParallax() {
    const bgElements = document.querySelectorAll('.bg-image');
    const scrollTop = window.pageYOffset;
    
    bgElements.forEach(element => {
        const speed = element.getAttribute('data-speed');
        const offsetY = scrollTop * speed;
        
        // Create a slight horizontal movement as well for more depth
        const horizontalSpeed = parseFloat(speed) * 0.3;
        const offsetX = Math.sin(scrollTop * 0.001) * scrollTop * horizontalSpeed;
        
        element.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
    });
}

// Slow background images (very slow speed)
function handleSlowBackgroundParallax() {
    const scrollTop = window.pageYOffset;
    const windowHeight = window.innerHeight;
    const documentHeight = document.body.scrollHeight;
    
    // Calculate scroll percentage (0 to 1)
    const scrollPercentage = scrollTop / (documentHeight - windowHeight);
    
    // Apply very slow movement to the background images
    const slowBgImages = document.querySelectorAll('.slow-bg-image');
    
    slowBgImages.forEach((element, index) => {
        // Define different movement patterns for each background
        let yMove, xMove;
        
        switch(index) {
            case 0: // First background
                yMove = scrollPercentage * 100; // moves down 100px at full scroll
                xMove = scrollPercentage * 50; // moves right 50px
                break;
            case 1: // Second background
                yMove = scrollPercentage * 70;
                xMove = -scrollPercentage * 30; // moves left 30px
                break;
            case 2: // Third background
                yMove = -scrollPercentage * 60; // moves up 60px
                xMove = scrollPercentage * 20;
                break;
            case 3: // Fourth background
                yMove = -scrollPercentage * 80;
                xMove = -scrollPercentage * 40;
                break;
            default:
                yMove = scrollPercentage * 50;
                xMove = 0;
        }
        
        // Apply transforms - these move very slowly with page scroll
        element.style.transform = `translate(${xMove}px, ${yMove}px)`;
    });
}

// Reveal text animation
function handleRevealText() {
    const revealElements = document.querySelectorAll('.reveal-text');
    
    revealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('visible');
        } else {
            element.classList.remove('visible');
        }
    });
}

// Combined scroll handler
function handleScroll() {
    handleParallax();
    handleBackgroundParallax();
    handleSlowBackgroundParallax();
    handleRevealText();
}

// Add a subtle floating animation to elements
function initFloatingElements() {
    // Add floating animation to planets
    const bgElements = document.querySelectorAll('.bg-image');
    bgElements.forEach((element, index) => {
        if (index % 2 === 0) {
            element.style.animation = `float ${5 + index}s ease-in-out infinite`;
        } else {
            element.style.animation = `floatReverse ${6 + index}s ease-in-out infinite`;
        }
    });
}

// Add event listeners
window.addEventListener('scroll', handleScroll);
window.addEventListener('resize', handleScroll);

// Initial check for elements in view on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initial handling of all effects
    handleScroll();
    
    // Add floating animations
    initFloatingElements();
    
    // Add star field effect
    createStarField();
});

// Create a star field in the background
function createStarField() {
    const starsContainer = document.createElement('div');
    starsContainer.className = 'stars-container';
    starsContainer.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
    `;
    
    // Create multiple stars
    for (let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        const size = Math.random() * 3 + 1; // Random size between 1-4px
        
        star.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: white;
            opacity: ${Math.random() * 0.5 + 0.3};
            border-radius: 50%;
            top: ${Math.random() * 100}%;
            left: ${Math.random() * 100}%;
            animation: twinkle ${Math.random() * 5 + 2}s linear infinite;
        `;
        
        starsContainer.appendChild(star);
    }
    
    document.body.prepend(starsContainer);
}

// Add CSS animations
document.head.insertAdjacentHTML('beforeend', `
    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        @keyframes floatReverse {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(15px) rotate(-3deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        @keyframes twinkle {
            0% { opacity: 0.3; }
            50% { opacity: 0.8; }
            100% { opacity: 0.3; }
        }
    </style>
`);