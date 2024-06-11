<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DG Air Brake Store - Prototype 2</title>
    <link rel="stylesheet" href="resources/styles/store_styles/prototype2_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4b11123c7d.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header-content">
            <img src="resources/images/DGBusinessLogo.png" class="business-logo">
            <nav>
                <a href="home.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Floating Icons -->
    <div class="floating-icons">
        <a href="#" id="search-icon" onclick="toggleSearch()"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#" id="cart-icon"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="#" id="profile-icon" onclick="openLoginModal()"><i class="fa-regular fa-user"></i></a>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <img src="resources/images/home_images/image1.png" alt="Hero Image" class="hero-image">
        <div class="hero-text">
            <h1>Quality Air Brake & Hydraulic Repairs</h1>
            <a href="shop.php" class="hero-button">Shop Now</a>
        </div>
    </section>

    <!-- Main Content -->
    <main>
        <div id="main-product-grid">
            <!-- Example product box, duplicate and update with actual product data -->
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/bracket_for_replacement.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Bracket For Replacement</h2>
                    <p class="product-price">RXX.XX</p>
                </div>
            </div>
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/clamp_band.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Clamp Band</h2>
                    <p class="product-price">R149.99</p>
                </div>
            </div>
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/door_control_modulator.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Door Control Modulator</h2>
                    <p class="product-price">R329.99</p>
                </div>
            </div>
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/electrical_wire.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Electrical Wire</h2>
                    <p class="product-price">R99.90</p>
                </div>
            </div>
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/emergency_tag.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Emergency Tag</h2>
                    <p class="product-price">R59.99</p>
                </div>
            </div>
            <div class="product-box">
                <div class="product-image-container">
                    <img class="product-image" src="resources/images/products/foot_brake_modulator.jpg" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2 class="product-name">Foot Brake Modulator</h2>
                    <p class="product-price">R250.00</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <nav>
                <a href="home.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="contact-info">
                <p>Contact us: 123-456-7890</p>
                <div class="social-media">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Product Modal -->
    <div id="product-modal" class="modal">
        <div class="product-modal-content">
            <div class="product-modal-header">
                <h2>Product Name</h2>
                <span class="product-modal-close" onclick="closeProductModal()">&times;</span>
            </div>
            <div class="product-modal-body">
                <div class="product-modal-image-container">
                    <img class="product-modal-image" alt="Product Image">
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

    <!-- Login Modal -->
    <div id="login-modal" class="modal">
        <div class="login-modal-content">
            <span class="login-modal-close" onclick="closeLoginModal()">&times;</span>
            <h2>Login</h2>
            <form id="login-form" action="/src/main/controllers/LoginController.php?action=attemptLogin" method="post">
                <div class="login-modal-form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="login-modal-form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
                <a href="registration.html" id="register-link">Register</a>
            </form>
        </div>
    </div>

    <script src="resources/scripts/store_scripts/store.js"></script>
    <script src="resources/scripts/store_scripts/product_modal.js"></script>
    <script src="resources/scripts/store_scripts/login_modal.js"></script>

</body>
</html>
