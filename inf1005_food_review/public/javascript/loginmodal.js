// <!-- Password Toggle Script -->
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "/Images/eye.png"; // Change to visible eye icon
    } else {
        passwordInput.type = "password";
        eyeIcon.src = "/Images/hidden.png"; // Change back to hidden eye icon
    }
}

// Auto-reset form when modal closes
document.addEventListener("DOMContentLoaded", function () {
    var loginModal = document.getElementById('loginModal');

    loginModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('loginForm').reset(); // Reset form when modal closes
    });
});
