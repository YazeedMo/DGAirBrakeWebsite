// Get the modal window
const modal = document.getElementById("login-modal");

// Get the button that opens the modal
const profileIcon = document.getElementById("profile-icon");

// Get the span element that closes the modal
const closeButton = document.querySelector(".close");

const usernameTextField = document.getElementById("username");
const passwordField = document.getElementById("password");
const messageLabel = document.getElementById("message");

// Get the main section to prevent scrolling
const mainSection = document.querySelector(".main-section");

// Get the background
const background = document.querySelector(".store");

profileIcon.addEventListener("click", function(event) {

    event.preventDefault();         // Prevent default action of the <a> tag
    modal.style.display = "block";
    background.classList.add("disable");
    usernameTextField.focus();

})

closeButton.onclick = function() {

    modal.style.display = "none";
    background.classList.remove("disable");

}

// Fix this function -> Suppose to close modal window when clicking on background
// window.onclick = function(event) {

//     if (event.target.classList.contains("store")) {
//         modal.style.display = "none";
//         background.classList.remove("disable");
//     }
// }

const loginForm = document.getElementById("login-modal");

loginForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const form = document.getElementById("login-form");
    const formData = new FormData(form);

    fetch("src/main/controllers/LoginController.php?action=attemptLogin", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (response.ok) {
            // Check if the response is a redirect (status code 302)
            if (response.redirected) {

                usernameTextField.value = "";

                // Manually redirect to the location specified in the response
                window.location.href = response.url;
            }
            else {
                return response.json();
            }
        }
    })
    .then(data => {

        console.log(data.message);
        if (data.message == "Invalid") {
            messageLabel.textContent = "Invalid Username or Password";
            usernameTextField.select();
        }
        else {
            passwordField.value = "";
            modal.style.display = "none";
            background.classList.remove("disable");
            location.reload();
        }
        console.log(data);
    })
    .catch(error => {
        console.log("Error:", error);
    });

});