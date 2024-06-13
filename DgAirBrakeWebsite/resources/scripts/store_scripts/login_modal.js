const profileIcon = document.getElementById("profile-icon");

const loginModal = document.getElementById("login-modal");
const closeButton = document.querySelector(".close");

const messageLabel = document.getElementById('message');

const usernameField = document.getElementById('username');
const passwordField = document.getElementById('password');


loginModal.style.display = 'none';
messageLabel.style.display = 'none';

function openLoginModal() {

    if (currentUserLabel.textContent === 'Login') {
        console.log(loginModal.style.display);

        if (loginModal.style.display === 'none') {
            loginModal.style.display = 'block';
            usernameField.select();
        }
        else {
            loginModal.style.display = 'none';
        }
    }
    else {
        window.location.href = 'profile.php';
    }

}

function closeLoginModal() {

    loginModal.style.display = 'none';

}

const loginForm = document.getElementById("login-form");

loginForm.addEventListener("submit", function(event) {

    messageLabel.textContent = 'login form sent';
    event.preventDefault();

    const formData = new FormData(loginForm);

    fetch("src/main/controllers/LoginController.php?action=attemptLogin", {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            console.log('error');
        }
        else {
            return response.json();
        }
    })
    .then(data => {
        console.log(data);
        if (data.message === 'Invalid') {
            messageLabel.style.display = 'block';
            messageLabel.textContent = 'Incorrect username or password';
        }
        else if (data.message === 'Redirect') {
            console.log('In correct place');
            window.location.href = data.url;
        }
        else {
            messageLabel.style.display = 'none';
            location.reload();
        }
    })

});