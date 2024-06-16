const cartModal = document.getElementById('cart-modal');

const cartItemsContainer = document.querySelector('.cart-items');
const finalTotal = document.querySelector('.final-total');



cartModal.style.display = 'none';

function openCartModal() {

    if (currentUserLabel.textContent === 'Login') {
        if (loginModal.style.display === 'none') {
            loginModal.style.display = 'block';
        }
    }
    else {
        cartModal.style.display = 'block';
    }

}

function closeCartModal() {

    saveCartState();
    cartModal.style.display = 'none';

}

async function getCartProducts() {

    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=getCartItems');
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

async function displayCartProducts() {

    const allCartProducts = await getCartProducts();

    allCartProducts.forEach(element => {
        
        var cartItemPrice = document.createElement('p');
        cartItemPrice.classList.add('cart-item-price');
        cartItemPrice.textContent = 'Unit Price: ' + element['product']['price'];

        var cartItemName = document.createElement('p');
        cartItemName.classList.add('cart-item-name');
        cartItemName.textContent = element['product']['productName'];

        var productID = document.createElement('p');
        productID.classList.add('cart-item-id');
        productID.textContent = 'Product ID: ' + element['product']['productID'];

        var cartItemDetails = document.createElement('div');
        cartItemDetails.classList.add('cart-item-details');

        cartItemDetails.appendChild(productID);
        cartItemDetails.appendChild(cartItemName);
        cartItemDetails.appendChild(cartItemPrice);

        var cartItemImage = document.createElement('img');
        cartItemImage.classList.add('cart-item-image');
        cartItemImage.src = element['product']['imageURL'];

        var cartItemRow1 = document.createElement('div');
        cartItemRow1.classList.add('cart-item-row1');

        cartItemRow1.appendChild(cartItemImage);
        cartItemRow1.appendChild(cartItemDetails);

        var quantityIncrease = document.createElement('button');
        quantityIncrease.classList.add('quantity-increase');
        quantityIncrease.textContent = '+'

        var quantityInput = document.createElement('input');
        quantityInput.classList.add('quantity-input');
        quantityInput.setAttribute('type', 'number');
        quantityInput.setAttribute('min', '1');
        quantityInput.value = element['quantity'];

        var quantityDecrease = document.createElement('button');
        quantityDecrease.classList.add('quantity-decrease');
        quantityDecrease.textContent = '-';

        var cartItemQuantity = document.createElement('div');
        cartItemQuantity.classList.add('cart-item-quantity');

        cartItemQuantity.appendChild(quantityDecrease);
        cartItemQuantity.appendChild(quantityInput);
        cartItemQuantity.appendChild(quantityIncrease);

        var cartItemTotal = document.createElement('p');
        cartItemTotal.classList.add('cart-item-total');
        cartItemTotal.textContent = element['totalPrice'];

        var cartItemDelete = document.createElement('button');
        cartItemDelete.classList.add('cart-item-delete');
        cartItemDelete.textContent = 'Delete';
        cartItemDelete.onclick = function () {
            deleteCartItem(element, cartItem);
        }

        var cartItemRow2 = document.createElement('div');
        cartItemRow2.classList.add('cart-item-row2');

        cartItemRow2.appendChild(cartItemQuantity);
        cartItemRow2.appendChild(cartItemTotal);
        cartItemRow2.appendChild(cartItemDelete);

        var cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.appendChild(cartItemRow1);
        cartItem.appendChild(cartItemRow2);
        cartItem.setAttribute('data-cart-item-id', element['cartItemID']);

        quantityIncrease.addEventListener('click', () => {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateTotalPrice();
            updateFinalTotal();
        });

        quantityDecrease.addEventListener('click', () => {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateTotalPrice();
                updateFinalTotal();
            }
        })

        function updateTotalPrice() {
            
            var unitPrice = parseFloat(element['product']['price']);
            var quantity = parseInt(quantityInput.value);
            var totalPrice = unitPrice * quantity;
            cartItemTotal.textContent = totalPrice.toFixed(2);

        }

        cartItemsContainer.appendChild(cartItem);
        

    });

    updateFinalTotal();

}

function updateFinalTotal() {

    let total = 0;
    document.querySelectorAll('.cart-item-total').forEach(itemTotal => {
        total += parseFloat(itemTotal.textContent);
    });
    finalTotal.textContent = 'Final Total: ' + total.toFixed(2);

}

function collectUpdatedCartData() {

    const updatedCartData = [];

    // Loop through all cart items in the DOM
    document.querySelectorAll('.cart-item').forEach(cartItem => {
        
        const attribute = cartItem.getAttribute('data-cart-item-id');
        console.log(attribute);

    });

    return updatedCartData;

}

displayCartProducts();

async function deleteCartItem(element, cartItem) {

    const payload = {
        cartItemID: element['cartItemID']
    };

    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=deleteCartItem', {
            method: 'POST',
            headers: {
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        console.log(result.status === 'success');
        cartItem.remove();
        updateFinalTotal();

    }
    catch (error) {
        console.log('Error: ', error);
    }

}

async function saveCartState() {

    // Get CartItemID and quantities from the cart
    const cartItems = document.querySelectorAll('.cart-item');
    const cartData = Array.from(cartItems).map(item => {
        const cartItemID = item.getAttribute('data-cart-item-id');
        const quantity = item.querySelector('.quantity-input').value;
        return { cartItemID, quantity};
    })

    // Save it to database
    const payload = {
        cartItemUpdates: cartData
    };

    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=updateCartItems', {
            method: 'POST',
            headers: {
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify(cartData)
        });

        const result = await response.json();
        console.log(result.status === 'success');

    }
    catch (error) {
        console.log('Error: ', error);
    }

}

async function checkout() {

    saveCartState();

    try {
        const response = await fetch('src/main/controllers/StoreController.php?action=makeOrder');
        const result = await response.json();
        if (result.message === 'redirect') {
            window.location.href = result.url;
        }
    }
    catch (error) {
        console.log('Error: ', error);
    }


}

function continueShopping() {

    closeCartModal();

}