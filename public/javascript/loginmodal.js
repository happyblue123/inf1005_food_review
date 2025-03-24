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

function submitForgotPwd() {
    var email = document.getElementById("email_reset").value;
    var messageDiv = document.getElementById("forgotPwdMessage"); // Get message div

    console.log("Email entered:", email); // Debugging

    if (email === "") {
        messageDiv.innerHTML = '<span style="color: red;">Please enter your email!</span>';
        return;
    }

    // Sending a POST request to /forgotPwd
    fetch('/forgotPwd', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Specify JSON format
        },
        body: JSON.stringify({ email: email }) // Send email as JSON
    })
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = '<span style="color: green;">Password reset link sent to: ' + email + '</span>';
        } else {
            messageDiv.innerHTML = '<span style="color: red;">Error: ' + data.message + '</span>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageDiv.innerHTML = '<span style="color: red;">Something went wrong, please try again later.</span>';
    });
}


// Auto-reset form when modal closes
document.addEventListener("DOMContentLoaded", function () {
    var loginModal = document.getElementById('loginModal');

    loginModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('loginForm').reset(); // Reset form when modal closes
    });
});


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("forgotPwdLink").addEventListener("click", function() {
        var forgotPwdContainer = document.getElementById("forgotPwdContainer");
        if (forgotPwdContainer.style.display === "none") {
            forgotPwdContainer.style.display = "block";
        } else {
            forgotPwdContainer.style.display = "none";
        }
    });
});