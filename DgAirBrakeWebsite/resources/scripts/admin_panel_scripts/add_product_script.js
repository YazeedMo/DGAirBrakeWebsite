const addNewProductNotification = document.getElementById('add-new-product-notification');
const productNameField = document.getElementById('product-name');
const descriptionField = document.getElementById('description');
const priceField = document.getElementById('price');
const quantityAvailableField = document.getElementById('quantity-available');
const fileInput = document.getElementById('image');

productNameField.value = "testProduct";

function addProduct() {

    const modal = document.getElementById('add-product-modal');
    const addProductBtn = document.getElementById('add-product-btn');
    const closeBtn = document.getElementsByClassName('close')[0];

    modal.style.display = "block";

    closeBtn.onclick = function() {
        modal.style.display = "none";
        location.reload();
    }

    onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

}

async function submitForm(event) {

    event.preventDefault();

    // const formData = new FormData();
    // formData.append('fileToUpload', fileInput.files[0]);

    const inputsArray = [
        productNameField, descriptionField, priceField, quantityAvailableField, fileInput
    ];

    var allFieldsValid = true;

    for (var i = 0; i < inputsArray.length; i++) {
        const validInput = validateInput(inputsArray[i].id);
        if (validInput === false) {
            allFieldsValid = false;
            break;
        }
    }

    if (allFieldsValid) {
        sendForm();
    }

}

function validateInput(inputId) {

    if (inputId === 'product-name') {
        return isValidProductName();
    }
    else if (inputId === 'description') {
        return isValidDescription();
    }
    else if (inputId === 'price') {
        return isValidPrice();
    }
    else if (inputId === 'quantity-available') {
        return isValidQuantityAvailable();
    }
    else if (inputId === 'image') {
        return isValidImage();
    }

}

function isValidProductName() {

    if (productNameField.value.trim() === "") {
        displayNotification("Please fill in product name");
        productNameField.select();
        return false;
    }
    
    return true;

}
function isValidDescription() {

    if (descriptionField.value.trim() === "") {
        descriptionField.value = productNameField.value;
    }
    
    return true;

}
function isValidPrice() {

    if (priceField.value < 0) {
        displayNotification('Invalid Price');
        priceField.select();
        return false;
    }

    return true;

}
function isValidQuantityAvailable() {

    if (quantityAvailableField.value < 0) {
        displayNotification('Invalid Quantity');
        quantityAvailableField.select();
        return false;
    }

    return true

}
function isValidImage () {

    if (fileInput.files.length > 0) {

        const file = fileInput.files[0];
        const fileName = file.name.toLowerCase();
        const fileType = file.type.toLowerCase();

        if (fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') || fileName.endsWith('.png') ||
        fileType === 'image/jpeg' || fileType === 'image/png') {
            return true;
        }
        else {
            displayNotification('File must be a JPG or PNG');
            return false;
        }
    }
    else {
        displayNotification('Please select a file'); 
        return false;
    }

}

function displayNotification(message) {

    addNewProductNotification.textContent = message;
    addNewProductNotification.style.display = 'block';

}

async function sendForm() {

    const formData = new FormData();
    formData.append('productName', productNameField.value);
    formData.append('description', descriptionField.value);
    formData.append('price', priceField.value);
    formData.append('quantityAvailable', quantityAvailableField.value);
    formData.append('fileToUpload', fileInput.files[0]);

    try {

        const response = await fetch('src/main/controllers/AdminPanelController.php?action=addProduct', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        console.log(result.message === 'success'); 
        location.reload();

    }
    catch (error) {
        console.log('Error: ', error);
    }
}

