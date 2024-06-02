function testData() {

    document.getElementById("username").value = "testerer";
    document.getElementById("email").value = "tester@gmail.com";
    document.getElementById("password").value = "tester";
    document.getElementById("confirm-password").value = "tester";
    document.getElementById("address-string").value = "qweqweqwe";
    document.getElementById("area-code").value = "7798";
    document.getElementById("card-number").value = "123123123123123123";
    document.getElementById("expiration-date").value = "10/25";
    document.getElementById("card-type").value = "visa";

}

testData();


function showTab(tabId) {

    // Hide all form sections
    const formSections = document.querySelectorAll('.form-section');
    formSections.forEach(function(section) {
        section.style.display = 'none';
    });

    // Show the selected tab
    document.getElementById(tabId).style.display = 'block';

    updateButtonStates();

}

function showPrev() {
    var formSections = document.querySelectorAll('.form-section');
    var currentTab;

    // Find the currently visible tab
    for (var i = 0; i < formSections.length; i++) {
        if (formSections[i].style.display !== 'none') {
            currentTab = formSections[i];
            break;
        }
    }

    // Hide current tab
    currentTab.style.display = 'none';

    // Show previous tab
    var prevIndex = Array.from(formSections).indexOf(currentTab) - 1;
    var prevTab = formSections[prevIndex];
    prevTab.style.display = 'block';

    // Update button states
    updateButtonStates();
}

function showNext() {

    var formSections = document.querySelectorAll('.form-section');
    var currentTab;

    // Find the currently visible tab
    for (var i = 0; i < formSections.length; i++) {
        if (formSections[i].style.display !== 'none') {
            currentTab = formSections[i];
            break;
        }
    }

    // Hide current tab
    currentTab.style.display = 'none';

    // Show next tab
    var nextIndex = Array.from(formSections).indexOf(currentTab) + 1;
    var nextTab = formSections[nextIndex];
    nextTab.style.display = 'block';

    // Update button states
    updateButtonStates();
}



async function submitForm() {

    const formSections = Array.from(document.querySelectorAll('.form-section'));

    var invalidFormFound = false;

    // Loop through all form sections
    for (let i = 0; i < formSections.length; i++) {

        var currentFormSection = formSections[i];

        const inputFields = Array.from(currentFormSection.querySelectorAll('input, textarea, select'));

        // Loop through all input fields of current form section
        for (let j = 0; j < inputFields.length; j++) {

            var currentInputField = inputFields[j];

            // Check if all fields are filled in
            if (currentInputField.value.trim() === "") {
                console.log("Found Empty field");
                showInvalidForm(currentFormSection, "Please fill in all fields", currentInputField);
                invalidFormFound = true;
                break;
            }

            // Check if all fields have valid data
            else {

                console.log("checking for invalid data");

                var message = validateField(currentInputField);
                if (message !== null) {
                    console.log("Invlaid data found");
                    showInvalidForm(currentFormSection, message, currentInputField);
                    invalidFormFound = true;
                    break;
                }
                // All fields are filled in and valid, clear error and check next form section
                else {
                    currentFormSection.querySelector('.notification').style.display = 'none';
                    invalidFormFound = false;
                }
            }

        }

        if (invalidFormFound) {
            break;
        }


    }

    // All fields are filled in, all data is valid, proceed
    if (!invalidFormFound) {

        // Check if username and password is valid
        const isValidUsername = await checkUsername();
        const isValidCardNumber = await checkCardNumber();
        if (!isValidUsername) {

            const form = document.getElementById('personal-details-section');
            const field = document.getElementById('username');

            showInvalidForm(form, "Username Taken", field);
        }
        else if (!isValidCardNumber) {

            const form = document.getElementById('card-details-section');
            const field = document.getElementById('card-number');

            showInvalidForm(form, "Card number already exists", field);
        }
        else {
    
            console.log('All good to go');
            sendForm();

        }

    }

}

function showInvalidForm(form, notificationMessage, inputField) {

    // Disable all form sections
    const formSections = Array.from(document.querySelectorAll('.form-section'));
    formSections.forEach(function(section) {
        section.style.display = "none";
    })

    // Make only necessary form visible
    form.style.display = 'block';

    // Set notification message
    const notificationLabel = form.querySelector('.notification');
    notificationLabel.textContent = notificationMessage;
    notificationLabel.style.display = 'block';

    // Highlight input field
    inputField.select();

    updateButtonStates();


}

function validateField(field) {

    if (field.id === "email") {
        if (!isValidEmail(field.value)) {
            return "Invalid Email";
        } 
        return null;
    }
    else if (field.id === "confirm-password") {
        if (!isValidConfirmPassword(field.value)) {
            return "Passwords do not match";
        }
        return null;
    }
    else if (field.id === "card-number") {
        if (!isValidCardNumber(field.value)) {
            return "Invalid Card Number";
        }
        return null;
    }
    else if (field.id === "expiration-date") {
        if (!isValidExpirationDate(field.value)) {
            return "Invalid Expiration Date";
        }
        return null;
    }
    else {
        return null;
    }

}

function updateButtonStates() {

    const formSections = document.querySelectorAll('.form-section');
    var currentTabIndex = Array.from(formSections).findIndex(section => section.style.display === 'block');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    // Enable/disable previous and next buttons based on current tab
    if (currentTabIndex === 0) {
        prevBtn.disabled = true;
        nextBtn.disabled = false;
    }
    else if (currentTabIndex === formSections.length - 1) {
        prevBtn.disabled = false;
        nextBtn.disabled = true;
    }
    else {
        prevBtn.disabled = false;
        nextBtn.disabled = false;
    }

}



function isValidConfirmPassword(password) {

    const confirmPassword = document.getElementById("password").value;

    return password === confirmPassword;

}

function isValidEmail(email) {

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    return emailRegex.test(email);
}

function isValidCardNumber(cardNumber) {
    const cardNumberRegex = /^\d{13,19}$/;
    return cardNumberRegex.test(cardNumber);
}

function isValidExpirationDate(expirationDate) {
    const expirationDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!expirationDateRegex.test(expirationDate)) {
        return false;
    }

    const [month, year] = expirationDate.split('/').map(Number);
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1; // getMonth() returns 0-11
    const currentYear = currentDate.getFullYear() % 100; // get last two digits of year

    return year > currentYear || (year === currentYear && month >= currentMonth);
}



async function checkUsername() {

    try {
        const formData = new FormData();
        formData.append('username', document.getElementById('username').value);

        const response = await fetch('src/main/controllers/RegistrationController.php?action=checkUsername', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Empty repsonse');
        }

        console.log("herer");
        const data = await response.json();
        console.log(data);

        if (data.validUsername === false) {
            return false;
        }
        else {
            return true;
        }
    }
    catch (error) {
        console.log('in catch block');
        console.log('Error', error);
    }

}

async function checkCardNumber() {

    try {
        const formData = new FormData();
        formData.append('cardNumber', document.getElementById('card-number').value);

        const response = await fetch('src/main/controllers/RegistrationController.php?action=checkCardNumber', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Empty response');
        }

        const data = await response.json();
        console.log(data);

        if (data.validCardNumber === false) {
            return false;
        }
        else {
            return true;
        }
    }
    catch (error) {
        console.log(error);
    }

}

function gatherFormData() {

    // Personal Details
    // const personalDetails = new FormData();
    // personalDetails.append('username', document.getElementById('username').value);
    // personalDetails.append('email', document.getElementById('email').value);
    // personalDetails.append('password', document.getElementById('password').value)
    const personalDetails = {
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
    };

    // Address Information
    const addressInfo = {
        addressString: document.getElementById('address-string').value,
        areaCode: document.getElementById('area-code').value
    };

    // Card Details
    const cardDetails = {
        cardNumber: document.getElementById('card-number').value,
        expirationDate: document.getElementById('expiration-date').value,
        cardType: document.getElementById('card-type').value
    };

    // Combine all form data into a single object
    const formData = {
        personalDetails: personalDetails,
        addressInfo: addressInfo,
        cardDetails: cardDetails
    };

    // Convert the object to a JSON string
    const jsonData = JSON.stringify(formData);
    return jsonData;

    // const formData = new FormData();
    // formData.append('personalDetails', 'testering');
    // formData.append('addressInfo', addressInfo);
    // formData.append('cardDetails', cardDetails);

    // return formData;

}

function sendForm() {

    const formData = gatherFormData();

    fetch('src/main/controllers/RegistrationController.php?action=registerUser', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network repsonse was not ok');
        }
        else {
             return response.json();
        }
    })
    .then(data => {
        if (data.status === 'success') {
            window.location.href = data.redirectUrl;
        }
        else {
            console.log('Error:', data.message);
        }
    })
    .catch((error) => {
        console.log('Error:', error);
    });

}




