async function getAllProducts() {
    try {
        const response = await fetch('../../src/main/services/ProductService.php?action=getAllProducts');
        if (!response.ok) {
            throw new Error("Error fetching data");
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }
}

async function setup() {

    const productGrid = document.querySelector('.product-grid');
    
    const allProducts = await getAllProducts();

    console.log(allProducts);
    
    allProducts.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');

        const productImage = document.createElement('img');
        productImage.src = product.imageURL;
        productImage.alt = 'Product Image';
        productImage.classList.add('product-image');

        const productInfo = document.createElement('div');
        productInfo.classList.add('product-info');

        const productName = document.createElement('h3');
        productName.classList.add('product-title');
        productName.textContent = product.productName;

        const productPrice = document.createElement('p');
        productPrice.classList.add('product-price');
        productPrice.textContent = '$' + product.price;

        productInfo.appendChild(productName);
        productInfo.appendChild(productPrice);

        productCard.appendChild(productImage);
        productCard.appendChild(productInfo);

        productGrid.appendChild(productCard);
    });
}

setup();
