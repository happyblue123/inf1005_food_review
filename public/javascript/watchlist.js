function toggleWatchlist(element) {
    let movieId = element.getAttribute("data-movie-id");
    let movieName = element.getAttribute("data-movie-name");
    let isInWatchlist = element.getAttribute("data-in-watchlist") === "true";

    let url = isInWatchlist 
        ? `/remove-from-watchlist/${movieId}&${encodeURIComponent(movieName)}`
        : `/add-to-watchlist/${movieId}&${encodeURIComponent(movieName)}`;

    fetch(url, {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(response => response.json())  // Parse JSON response
    .then(data => {
        if (data.status === "success") {
            // Toggle the icon based on the response
            if (isInWatchlist) {
                element.classList.remove("fas", "in-watchlist");
                element.classList.add("far");
                element.setAttribute("data-in-watchlist", "false");
            } else {
                element.classList.remove("far");
                element.classList.add("fas", "in-watchlist");
                element.setAttribute("data-in-watchlist", "true");
            }
            showNotification(data.message, "success");
        } else if (data.status === "error") {
            // If the response indicates an error, show the login modal
            let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
            loginModal.show();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating the watchlist. Please try again.", "error");
    });
}

// Function to show a notification
function showNotification(message, type) {
    const container = document.getElementById("notification-container");

    // Create a new notification element
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Style the notification
    notification.style.position = "relative";
    notification.style.marginBottom = "10px";
    notification.style.padding = "10px 20px";
    notification.style.borderRadius = "5px";
    notification.style.color = "#fff";
    notification.style.fontSize = "14px";
    notification.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
    notification.style.opacity = "0";
    notification.style.transition = "opacity 0.3s ease";

    // Set background color based on the type
    if (type === "success") {
        notification.style.backgroundColor = "#28a745"; // Green for success
    } else if (type === "error") {
        notification.style.backgroundColor = "#dc3545"; // Red for error
    }

    // Append the notification to the container
    container.appendChild(notification);

    // Make the notification visible
    setTimeout(() => {
        notification.style.opacity = "1";
    }, 10);

    // Remove the notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = "0";
        setTimeout(() => {
            container.removeChild(notification);
        }, 300); // Wait for the fade-out transition to complete
    }, 3000);
}
