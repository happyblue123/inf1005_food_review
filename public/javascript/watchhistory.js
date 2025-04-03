function toggleWatchHistory(element) {
    const movieId = element.getAttribute("data-movie-id");
    const movieName = element.getAttribute("data-movie-name");
    const isInHistory = element.getAttribute("data-in-history") === "true";

    const url = isInHistory
        ? `/remove-from-watchhistory/${movieId}&${encodeURIComponent(movieName)}`
        : `/add-to-watchhistory/${movieId}&${encodeURIComponent(movieName)}`;

    fetch(url, {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Update icon
            if (isInHistory) {
                element.src = "/Images/hidden.png";
                element.setAttribute("data-in-history", "false");
            } else {
                element.src = "/Images/eye.png";
                element.setAttribute("data-in-history", "true");
            }
            showNotification(data.message, "success");
        } else if (data.status === "error") {
            // Handle login or other errors
            let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
            loginModal.show();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating watch history.", "error");
    });
}

// ✅ Reuse the same notification function from watchlist.js
function showNotification(message, type) {
    const container = document.getElementById("notification-container");

    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Styling
    notification.style.position = "relative";
    notification.style.marginBottom = "10px";
    notification.style.padding = "10px 20px";
    notification.style.borderRadius = "5px";
    notification.style.color = "#fff";
    notification.style.fontSize = "14px";
    notification.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
    notification.style.opacity = "0";
    notification.style.transition = "opacity 0.3s ease";

    if (type === "success") {
        notification.style.backgroundColor = "#28a745";
    } else {
        notification.style.backgroundColor = "#dc3545";
    }

    container.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = "1";
    }, 10);

    setTimeout(() => {
        notification.style.opacity = "0";
        setTimeout(() => {
            container.removeChild(notification);
        }, 300);
    }, 3000);
}
