const currentUserLabel = document.querySelector('#profile-icon p');
const filterBox = document.getElementsByClassName('filter-box')[0];
const searchBox = document.getElementById('search-box');
const mainProductGrid = document.getElementById('main-product-grid');
filterBox.style.display = 'none';

// Open/Close Search box
function toggleSearch() {

    if (filterBox.style.display === 'none') {
        filterBox.style.display = 'flex';
        searchBox.select();
    }
    else {
        filterBox.style.display = 'none';
    }

}

// Search for relevant products when user clicks enter in search box
searchBox.addEventListener('keydown', function(event) {

    if (event.key === 'Enter' || event.keyCode === 13) {
        displayProductsByKeyword();
    }

})


// Get all products from database
async function getAllProducts() {
    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=getAllProducts');
        if (!response.ok) {
            throw new Error("Error fetching data");
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }
}

// Get products only by keyword
async function getProductsByKeyword() {

    const keyword = searchBox.value;

    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=getProductsByKeyword&keyword=' + keyword);
        if (!response.ok) {
            throw new Error('Error fetching data');
        }
        const data = await response.json();
        return data;
    }
    catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }

}
    
// Display all products
async function displayAllProducts() {

    const allProducts = await getAllProducts();

    console.log(allProducts);

    allProducts.forEach(product => {

        const productBox = document.createElement('div');
        productBox.classList.add('product-box');
 
        const productImageContainer = document.createElement('div');
        productImageContainer.classList.add('product-image-container');

        const productInfo = document.createElement('div');
        productInfo.classList.add('product-info');

        const productName = document.createElement('h2');
        productName.classList.add('product-name');
        productName.textContent = product.productName;

        const price = document.createElement('p');
        price.classList.add('product-price');
        price.textContent = 'R' + product.price;

        const productImage = document.createElement('img');
        productImage.src = product.imageURL;
        productImage.alt = 'Product Image';
        productImage.classList.add('product-image');

        productInfo.appendChild(productName);
        productInfo.appendChild(price);

        productImageContainer.appendChild(productImage);
        productBox.appendChild(productImageContainer);
        productBox.appendChild(productInfo);
        mainProductGrid.appendChild(productBox);

        productBox.productData = product

        productBox.onclick  = () => {
            showProductModal(productBox.productData);
        };

    })

}

// Display only products by keyword
async function displayProductsByKeyword() {

    mainProductGrid.replaceChildren();

    const allProducts = await getProductsByKeyword(searchBox.value);

    console.log(allProducts);

    allProducts.forEach(product => {

        const productBox = document.createElement('div');
        productBox.classList.add('product-box');
 
        const productImageContainer = document.createElement('div');
        productImageContainer.classList.add('product-image-container');

        const productInfo = document.createElement('div');
        productInfo.classList.add('product-info');

        const productName = document.createElement('h2');
        productName.classList.add('product-name');
        productName.textContent = product.productName;

        const price = document.createElement('p');
        price.classList.add('product-price');
        price.textContent = 'R' + product.price;

        const productImage = document.createElement('img');
        productImage.src = product.imageURL;
        productImage.alt = 'Product Image';
        productImage.classList.add('product-image');

        productInfo.appendChild(productName);
        productInfo.appendChild(price);

        productImageContainer.appendChild(productImage);
        productBox.appendChild(productImageContainer);
        productBox.appendChild(productInfo);
        mainProductGrid.appendChild(productBox);

        productBox.productData = product

        productBox.onclick  = () => {
            showProductModal(productBox.productData);
        };
    })
}


// Alway display all products when page loads
displayAllProducts();
