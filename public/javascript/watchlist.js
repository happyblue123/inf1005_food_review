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
            // Toggle the star icon based on the response
            if (isInWatchlist) {
                element.classList.remove("fas", "in-watchlist");
                element.classList.add("far");
                element.setAttribute("data-in-watchlist", "false");
            } else {
                element.classList.remove("far");
                element.classList.add("fas", "in-watchlist");
                element.setAttribute("data-in-watchlist", "true");
            }
        } else if (data.status === "error") {
            // If the response indicates an error, show the login modal
            let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
            loginModal.show();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while updating the watchlist. Please try again.");
    });
}
