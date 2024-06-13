const manageProductModal = document.getElementById('manage-product-modal');

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

addProductBtn.style.display = 'none';
editProductBtn.style.display = 'none';
deleteProductBtn.style.display = 'none';

var productIDInEdit = null;

// Function to close modal window
closeBtn.onclick = function() {
    resetModal();
    manageProductModal.style.display = 'none';
    getAllProducts();
}

// Runs when the user submits any product modal form
function submitForm(event) {

    event.preventDefault();

    if (addProductBtn.style.display !== 'none') {
        // Logic to add Product

        const inputsArray = [productNameField, descriptionField, priceField, quantityAvailableField, fileInput];

        var allFieldsValid = true;

        for (var i = 0; i < inputsArray.length; i++) {
            const validInput = validateInput(inputsArray[i].id);
            if (validInput === false) {
                allFieldsValid = false;
                break;
            }
        }

        if (allFieldsValid) {
            addProductProdedure();
        }

    }
    else if (editProductBtn.style.display !== 'none') {

        const inputsArray = [productNameField, descriptionField, priceField, quantityAvailableField];

        var allFieldsValid = true;

        for (var i = 0; i < inputsArray.length; i++) {
            const validInput = validateInput(inputsArray[i].id);
            if (validInput === false) {
                allFieldsValid = false;
                break;
            }
        }

        if (allFieldsValid) {
            editProductProcedure();
        }
        
    }
    else if (deleteProductBtn.style.display !== 'none') {
        deleteProductProcedure();
    }

}

// User clicks Add Product Button
function addProduct() {

    manageProductModal.style.display = 'block';

    priceField.value = 0;
    quantityAvailableField.value = 0;

    addProductBtn.style.display = 'block';

}

// User clicks Edit Product Button
function editProduct(productID) {

    productIDInEdit = productID;

    manageProductModal.style.display = 'block';

    displayProductData();

    editProductBtn.style.display = 'block';

    fileInput.previousElementSibling.textContent = "Image (Optional):";

}

// User clicks Delete Product Button
function deleteProduct(productID) {

    console.log(productID);

    productIDInEdit = productID;

    manageProductModal.style.display = 'block';

    modalHeading.textContent = 'Are you sure you want to delete this product?';

    displayProductData();

    productNameField.disabled = true;
    descriptionField.disabled = true;
    priceField.disabled = true;
    quantityAvailableField.disabled = true;
    fileInput.textContent = 'Image will be deleted';
    fileInput.disabled = true;

    deleteProductBtn.style.display = 'block';

}

// Final Add Product function
async function addProductProdedure() {

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

        resetModal();

        location.reload();
        

    }
    catch (error) {
        console.log('Error: ', error);
    }

}

// Final Edit Product function
async function editProductProcedure() {

    const formData = new FormData();
    formData.append('productId', productIDInEdit);
    formData.append('productName', productNameField.value);
    formData.append('description', descriptionField.value);
    formData.append('price', priceField.value);
    formData.append('quantityAvailable', quantityAvailableField.value);

    // Check if new file uploaded
    if (fileInput.files.length === 0) {
        formData.append('fileExist', 'false');
    }
    else {
        formData.append('fileExist', 'true');
        formData.append('fileToUpload', fileInput.files[0]);
    }

    try {

        const response = await fetch('src/main/controllers/AdminPanelController.php?action=editProduct', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        console.log(result);

        resetModal();

        location.reload();
        

    }
    catch (error) {
        console.log('Error: ', error);
    }

}

// Final Delete Product function
async function deleteProductProcedure() {

    if (deleteProductBtn.style.display !== 'none') {
        try {

            const response = await fetch('src/main/controllers/AdminPanelController.php?action=deleteProductByID&productId=' + productIDInEdit);

            const result = await response.json();
            console.log(result);

            location.reload();
            
        }
        catch (error) {
            console.log('Error: ', error);
        }
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

    if (priceField.value < 0 || priceField.value === "") {
        displayNotification('Invalid Price');
        priceField.select();
        return false;
    }

    return true;

}
function isValidQuantityAvailable() {

    if (quantityAvailableField.value < 0 || quantityAvailableField.value === "") {
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

    notificationLabel.textContent = message;
    notificationLabel.style.display = 'block';

}

async function displayProductData() {

    try {
        const response = await fetch('src/main/controllers/AdminPanelController.php?action=getProductByID&productId=' + productIDInEdit);
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

function resetModal() {

    productNameField.value = '';
    descriptionField.value = '';
    priceField.value = '';
    quantityAvailableField.value = '';
    fileInput.value = '';

    addProductBtn.style.display = 'none';
    editProductBtn.style.display = 'none';
    deleteProductBtn.style.display = 'none';

}