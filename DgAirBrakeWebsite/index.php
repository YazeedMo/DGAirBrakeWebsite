<?php
    
    require_once __DIR__ . '/src/main/model/User.php';
    require_once __DIR__ . '/src/main/model/Customer.php';
    require_once __DIR__ . '/src/main/model/Admin.php';
    require_once __DIR__ . '/src/main/util/Session.php';

    $username = 'Login';

    if (getSessionCurrentUser()) {
        $user = getSessionCurrentUser();
        $username = $user->getUsername();
        if ($user->getRole() === 'Admin') {
            header('Location: admin_panel.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DG Air Brake Store</title>
    <link rel="stylesheet" href="resources/styles/store_styles/style.css">
    <link rel="stylesheet" href="resources/styles/store_styles/product_modal_style.css">
    <link rel="stylesheet" href="resources/styles/store_styles/login_modal_style.css">
    <link rel="stylesheet" href="resources/styles/store_styles/cart_modal_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
 
    <script src="https://kit.fontawesome.com/4b11123c7d.js" crossorigin="anonymous"></script> 

</head>
<body>

    <div class="top-bar">
        <div class="left-section">
            <img src="resources/images/DGBusinessLogo.png" class="business-logo">
            <span class="business-name">Air Brake & <br> Hydraulic Repairs</span>
        </div>
        <div class="center-section">
            <a href="home.php" class="page-link">
                <div class="link-box">
                    <span class="link-name">Home</span>
                </div>
            </a>
        </div>
        <div class="right-section">
            <a href="#" class="icon-link" id="search-icon" onclick="toggleSearch()"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="#" class="icon-link" id="cart-icon" onclick="openCartModal()"><i class="fa-solid fa-cart-shopping"></i>
            <a href="#" class="icon-link" id="profile-icon" onclick="openLoginModal()">
                <i class="fa-regular fa-user"></i>
                <p><?php echo $username?></p>
            </a>
        </div>
    </div>

    <div class="main-container">
        <div class="filter-box">
            <input type="text" id="search-box" placeholder="Search...">
            <button id="search-box-icon-container" onclick="displayProductsByKeyword()">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div id="main-product-grid">
            <!-- <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/clamp_band.jpg">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Product Name</h2>
                    <p class="product-price">RXX.XX</p>
                </div>
            </div> -->

        </div>    
    </div>



    <footer>
        <!-- Footer content goes here -->
    </footer>


    <!-- The Modal Product Window -->
    <div id="product-modal" class="modal" style="display: none;">
        <div class="product-modal-content">
            <div class="product-modal-header">
                <h2>Product Name</h2>
                <span class="product-modal-close" onclick="closeProductModal()">&times;</span>
            </div>
            <div class="product-modal-body">
                <div class="product-modal-image-container">
                    <img class="product-modal-image">
                </div>
                <div class="product-modal-description">
                    <h3>Description:</h3>
                    <p>Product Description</p>
                </div>
            </div>
            <div class="product-modal-footer">
                <div class="product-modal-price">Price</div>
                <button class="product-modal-add-to-cart-btn" onclick="addToCart()">Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- The Modal Log In Window -->
    <div id="login-modal" class="modal">
        <div class="login-modal-content">
            <span class="login-modal-close" onclick="closeLoginModal()">&times;</span>
            <h2>Login</h2>
            <p id="message">Message</p>
            <form id="login-form" action="/src/main/controllers/LoginController.php?action=attemptLogin" method="post">
                <div class="login-modal-form-group" id="login-modal-form-username-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>
                </div>
                <div class="login-modal-form-group" id="login-modal-form-password-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                </div>
                <button type="submit">Login</button>
                <a href="registration.php" id="register-link">Register</a>
            </form>
        </div>
    </div>

    <!-- The Modal Cart window -->
     <div id="cart-modal" class="modal">
        <div class="cart-modal-content">
            <span class="cart-modal-close" onclick="closeCartModal()">&times;</span>
            <h2>Your Cart</h2>
            <div class="cart-notification" id="class-notification">
                <p>This is a notification</p>
            </div>
            <div class="cart-items">

                <!-- <div class="cart-item">

                    <div class="cart-item-row1">
                        <img src="resources/images/products/bracket_for_replacement.jpg" alt="Item Image" class="cart-item-image">
                        <div class="cart-item-details">
                            <p class="cart-item-id">ID: 2</p>
                            <p class="cart-item-name">Item Name</p>
                            <p class="cart-item-price">Unit Price: 90</p>
                        </div>
                    </div>
                    <div class="cart-item-row2">
                        <div class="cart-item-quantity">
                            <button class="quantity-decrease">-</button>
                            <input type="number" value="1" min="1" class="quantity-input">
                            <button class="quantity-increase">+</button>
                        </div>
                        <p class="cart-item-total">Total: 100</p>
                        <button class="cart-item-delete">Delete</button>
                    </div>

                </div> -->

            </div>
            <div class="cart-total">

                <p class="final-total">Final Total: 2323</p>

            </div>
            <div class="cart-bottom">
                <button class="checkout-button" onclick="checkout()">Proceed to Checkout</button>
                <button class="continue-button" onclick="continueShopping()">Continue Shopping</button>
            </div>
        </div>
     </div>

    <script src="resources/scripts/store_scripts/store.js"></script>
    <script src="resources/scripts/store_scripts/product_modal.js"></script>
    <script src="resources/scripts/store_scripts/login_modal.js"></script>
    <script src="resources/scripts/store_scripts/cart_modal.js"></script>

</body>
</html>