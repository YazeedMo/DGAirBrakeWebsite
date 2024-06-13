const manage_product_modal = document.getElementById('manage-product-modal');
const closeBtn = document.getElementsByClassName('close')[0];
const modalHeading = document.getElementById('modal-heading');
const notificationLabel = document.getElementById('notification-label');
const productNameField = document.getElementById('product-name');
const descriptionField = document.getElementById('description');
const priceField = document.getElementById('price');
const quantityAvailableField = document.getElementById('quantity-available');
const fileInput = document.getElementById('image');
const addProductBtn = document.getElementById('add-product-btn');
const editProductBtn = document.getElementById('edit-product-btn');
const deleteProductBtn = document.getElementById('delete-product-btn');
var productInEdit = null;

function editProduct(product) {

    productIdInEdit = productId;

    manage_product_modal.style.display = 'block';
    modalHeading.textContent = "Edit Product";
    notificationLabel.style.display = 'none';

    addProductBtn.style.display = 'none';
    deleteProductBtn.style.display = 'none';

    displayProductData();

    closeBtn.onclick = function() {
        manage_product_modal.style.display = 'none';
        location.reload();
    }

}

function deleteProduct(product) {

    productIdInEdit = productId;

    manage_product_modal.style.display = 'block';
    modalHeading.textContent = 'Are you sure you want to delete this product?';
    notificationLabel.style.display = 'none';

    addProductBtn.style.display = 'none';
    editProductBtn.style.display = 'none';

    displayProductData();

    productNameField.disabled = true;
    descriptionField.disabled = true;
    priceField.disabled = true;
    quantityAvailableField.disabled = true;
    fileInput.disabled = true;

    closeBtn.onclick = function() {
        manage_product_modal.style.display = 'none';
        location.reload();
    }


}

async function displayProductData() {

    try {
        const response = await fetch('src/main/controllers/AdminPanelController.php?action=getProductByID&productId=' + productIdInEdit);
        if (!response.ok) {
            throw new Error('Empty response');
        }
        const data = await response.json();

        console.log(data);
        
        productNameField.value = data.productName;
        descriptionField.value = data.description;
        priceField.value = data.price;
        quantityAvailableField.value = data.quantityAvailable;
        
    }    
    catch (error) {
        console.log(error);
    }

}

async function submitForm(event) {

    // Edit Product
    if (editProductBtn.style.display !== 'none') {

        const inputsArray = [
            productNameField, descriptionField, priceField, quantityAvailableField
        ];

        var allFieldsValid = true;
        for (i = 0; i < inputsArray.length; i++) {
            const validInput = validateInput(inputsArray[i].id);
            if (validInput === false) {
                allFieldsValid = false;
                break
            }
        }

        if (allFieldsValid) {
            // Send form
        }

    }
    // Delete Product
    else if (deleteProductBtn.style.display !== 'none') {
        
    }


    event.preventDefault();

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

    if (priceField.value.trim() === "") {
        priceField.value = 0;
    }
    else if (priceField.value < 0) {
        displayNotification('Invalid Price');
        priceField.select();
        return false;
    }

    return true;

}
function isValidQuantityAvailable() {

    if (quantityAvailableField.value.trim() === "") {
        quantityAvailableField.value = 0;
    }
    else if (quantityAvailableField.value < 0) {
        displayNotification('Invalid Quantity');
        quantityAvailableField.select();
        return false;
    }

    return true

}
function isValidImage () {

    if (addProductBtn.style.display === 'none') {
        if (fileInput.files.length <= 0) {
            return true;
        }
    }

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

    notificationLabel.textContent = message;
    notificationLabel.style.display = 'block';

}


async function sendForm() {

    if (deleteProductBtn.style.display !== 'none') {
        try {

            const response = await fetch('src/main/controllers/AdminPanelController.php?action=deleteProductByID&productId=' + productIdInEdit);

            const result = await response.json();
            console.log(result);

            location.reload();
            
        }
        catch (error) {
            console.log('Error: ', error);
        }
    }
    else {
        
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

}

