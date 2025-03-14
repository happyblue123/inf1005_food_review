document.addEventListener('DOMContentLoaded', function() {
    console.log('Document is ready!');

    // Light up elements on hover
    const galleryImages = document.querySelectorAll('.gallery img');
    galleryImages.forEach(img => {
        img.addEventListener('mouseover', function() {
            img.style.filter = 'brightness(1.2)';
        });
        img.addEventListener('mouseout', function() {
            img.style.filter = 'brightness(1)';
        });
    });

    // Add click event to button
    const learnMoreButton = document.querySelector('.btn-custom');
    learnMoreButton.addEventListener('click', function() {
        alert('Thank you for clicking the Learn More button!');
    });

    // Image gallery transition
    const imageGallery = document.querySelector('.image-gallery');
    const images = [
        '../Images/pexels-ash-craig-122861-376464.jpg',
        '../Images/pexels-evonics-1058277.jpg',
        '../Images/pexels-janetrangdoan-1099680.jpg',
        '../Images/pexels-life-of-pix-67468.jpg',
        '../Images/pexels-pixabay-262047.jpg',
        '../Images/pexels-xmtnguyen-699953.jpg', 
        '../Images/pexels-robinstickel-70497.jpg',
        '../Images/pexels-rajesh-tp-749235-1633525.jpg'
    ];
    let currentIndex = 0;

    setInterval(() => {
        const imgElements = imageGallery.querySelectorAll('img');
        imgElements.forEach((img, index) => {
            img.style.opacity = 0;
            setTimeout(() => {
                img.src = images[(currentIndex + index) % images.length];
                img.style.opacity = 1;
            }, 1000);
        });
        currentIndex = (currentIndex + 1) % images.length;
    }, 3000);

    // // Resize header on scroll
    // const header = document.querySelector('header');
    // window.addEventListener('scroll', function() {
    //     if (window.scrollY > 50) {
    //         header.classList.add('shrink');
    //     } else {
    //         header.classList.remove('shrink');
    //     }
    // });
});