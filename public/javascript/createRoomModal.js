document.addEventListener("DOMContentLoaded", function () {
    // Get the modal, button, and close button
    const modal = document.getElementById("createRoomModal");
    const showModalButton = document.getElementById("showCreateRoomModal");
    const closeModalButton = document.getElementById("closeModal");

    const userInfo = document.getElementById('user-info');
    const username = userInfo.getAttribute('data-username');
    // Show the modal when the button is clicked
    showModalButton.onclick = function () {
        
        if (username == "") {
            openLoginModal();
            return
        }
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

function openLoginModal() {
    let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
    loginModal.show();
}