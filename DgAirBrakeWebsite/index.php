<?php
    
    require_once __DIR__ . '/src/main/model/User.php';
    require_once __DIR__ . '/src/main/model/Customer.php';
    require_once __DIR__ . '/src/main/model/Admin.php';

    session_start();
    
    $username = "Login";

    if (isset($_SESSION['current_user'])) {
        $user = $_SESSION['current_user'];
        $username = $user->getUsername();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DG Air Brake Store</title>
    <link rel="stylesheet" href="resources/styles/store_styles/style.css">
    <link rel="stylesheet" href="resources/styles/store_styles/login_modal_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
 
    <script src="https://kit.fontawesome.com/4b11123c7d.js" crossorigin="anonymous"></script> 

</head>
<body>

    <div class="store">    
        <header class="top-bar">
            <div class="logo">
                <img src="resources/images/DGBusinessLogo.png" alt="Business Logo">
            </div>
            <div class="business-name">Air Brake & Hydraulic Repairs</div>
            <div class="icons">
                <div class="search">
                    <input type="text" class="search-input" placeholder="Search...">
                    <a href="search"><i class="fa-solid fa-magnifying-glass" style="font-size: 1.2em;"></i></a>
                </div>
                <a href="cart"><i class="fa-solid fa-cart-shopping" style="font-size: 1.2em;"></i></a>
                <a href="profile" id="profile-icon"><i class="fa-regular fa-user" style="font-size: 1.2em;"></i></a>
                <p id="username"><?php echo $username?></p>
            </div>
        </header>

        <h1 id="product-info"></h1>

        <section class="main-section">
            <div class="main-grid">
                <div class="options-grid">


                    <div class="category-box">
                        <h3>Categories</h3>
                        <ul class="category-list">
                            <li><input type="checkbox" id="category1"><label for="category1">Category 1 </label></li>
                            <li><input type="checkbox" id="category2"><label for="category2">Category 2 </label></li>
                            <li><input type="checkbox" id="category3"><label for="category3">Category 3 </label></li>
                            <li><input type="checkbox" id="category4"><label for="category4">Category 4 </label></li>
                        </ul>
                    </div>


                </div>

                <div class="product-grid">
                    <!-- <div class="product-card">
                        <img src="../images/products/door_control_modulator.jpg" alt="product Image" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title">Brack for replacement</h3>
                            <p class="product-price">$99.99</p>
                        </div>
                    </div> -->
                </div>
                
            </div>
        </section>
    </div>

    <!-- The Modal Log In Window -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form id="login-form" action="/src/main/controllers/LoginController.php?action=attemptLogin" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit">Login</button>
                <a href="registration.html" id="register-link">Register</a>
                <p id="message"></p>
            </form>
        </div>
    </div>

    <script src="resources/scripts/store_scripts/store.js"></script>
    <script src="resources/scripts/store_scripts/login_modal.js"></script>

</body>
</html>