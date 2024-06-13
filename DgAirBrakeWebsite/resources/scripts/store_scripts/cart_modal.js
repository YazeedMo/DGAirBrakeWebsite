const cartModal = document.getElementById('cart-modal');



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

    cartModal.style.display = 'none';

}
