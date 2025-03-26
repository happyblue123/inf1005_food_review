document.addEventListener("DOMContentLoaded", function () {
    // Get the modal, button, and close button
    const modal = document.getElementById("createRoomModal");
    const showModalButton = document.getElementById("showCreateRoomModal");
    const closeModalButton = document.getElementById("closeModal");

    // Show the modal when the button is clicked
    showModalButton.onclick = function () {
        modal.style.display = "flex"; // Use "flex" to center the modal
    };

    // Close the modal when the close button is clicked
    closeModalButton.onclick = function () {
        modal.style.display = "none";
    };

    // Optional: Close the modal if you click outside of it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});