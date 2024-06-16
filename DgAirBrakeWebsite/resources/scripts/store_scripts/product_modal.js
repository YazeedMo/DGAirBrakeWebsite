const productModal = document.getElementById('product-modal');
const productModalName = document.querySelector('.product-modal-header h2');
const productModalImage = document.querySelector('.product-modal-image');
const productModalDescription = document.querySelector('.product-modal-description p');
const productModalPrice = document.querySelector('.product-modal-price');
const addToCartButton = document.querySelector('.product-modal-add-to-cart-btn');

function showProductModal(product) {

    productModal.style.display = 'flex';

    productModalName.textContent = product.productName;

    productModalImage.src = product.imageURL;
    productModalImage.alt = 'Product Image';

    productModalDescription.textContent = product.description;

    productModalPrice.textContent = 'R' + product.price;

    addToCartButton.productData = product;

}

function closeProductModal() {

    productModal.style.display = 'none';

}

async function addToCart() {

    if (currentUserLabel.textContent === 'Login') {
        console.log('Login before adding to cart');
        openLoginModal();
    }
    else {
        
        try {
            const response = await fetch('src/main/controllers/StoreController.php?action=addProductToCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(addToCartButton.productData)
            });
            if (response.ok) {
                const result = await response.json();
                console.log(result);
                location.reload();
            }
            else {
                console.error('Failed to add product to cart: ', response.statusText);
            }
        }
        catch (error) {
            console.log('Error: ', error);
        }
        
    }
    
}