document.addEventListener("DOMContentLoaded", function () 
{
    // Code to be executed when the DOM is ready (i.e. the document is 
    // fully loaded): 
    const images = document.querySelectorAll('.img-popup');

    // Add event listener to each element
    images.forEach(image => {
        image.addEventListener('click', imagepopup);
    });

    activateMenu()

    // registerEventListners(); // You need to write this function… 
});

function imagepopup(event) {
    const image = event.target
    const image_src = image.getAttribute("src")
    large_image = image_src.replace("small", "large");
    const popup_image = document.createElement("span")
    popup_image.setAttribute("class", "popup-overlay")
    popup_image.innerHTML = `<img src=${large_image}>`
    

    document.body.appendChild(popup_image);
    popup_image.addEventListener('click', () => {
        popup_image.remove();
    })
}

function activateMenu() { 
    const navLinks = document.querySelectorAll('nav a'); 
    navLinks.forEach(link => 
    { 
    if (link.href === location.href) 
    { 
    link.classList.add('active'); 
    } 
    }) 
} 