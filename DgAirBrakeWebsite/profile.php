<?php

    require_once __DIR__ . '/src/main/model/User.php';
    require_once __DIR__ . '/src/main/model/Customer.php';
    require_once __DIR__ . '/src/main/model/Admin.php';
    require_once __DIR__ . '/src/main/util/Session.php';

    if (!getSessionCurrentUser()) {
        header('Location: index.php');
    }
    else (
        $user = getSessionCurrentUser()
    )

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resources/styles/profile_styles/style.css">
</head>
<body>

    <header>
        <h1>Hello, <?php echo $user->getUsername()?></h1>
        <a href="index.php" class="return-to-store">Return to Store</a>

    </header>

    <div class="content-wrapper">

        <div class="tabs">
            <button id="profile-tab-link" class="tab-link" onclick="openTab(event, 'Profile')">Profile</button>
            <button id="shopping-tab-link" class="tab-link" onclick="openTab(event, 'Shopping')">Shopping Information</button>
            <button id="settings-tab-link" class="tab-link" onclick="openTab(event, 'Settings')">Settings</button>
        </div>

        <div id="Profile" class="tab-content">

            <div id="Personal" class="subsection">
                <h3>Personal Information</h3>
                <div class="accordion">
                    <button class="accordion-btn" onclick="toggleAccordion(event)">Expand</button>
                    <div class="panel">
                        <p><strong>Username:</strong> <span id="username">Username</span></p>
                        <p><strong>Email:</strong> <span id="email">email@example.com</span></p>
                        <!-- <button onclick="changePassword()">Change Password</button> -->
                    </div>
                </div>
            </div>

            <div id="Address" class="subsection">
                <h3>Address Information</h3>
                <div class="accordion">
                    <button class="accordion-btn" onclick="toggleAccordion(event)">Expand</button>
                    <div class="panel">
                        <p><strong>Address:</strong> <span id="address">123 Street, City</span></p>
                        <p><strong>Area Code:</strong> <span id="area-code">12345</span></p>
                    </div>
                </div>
            </div>

            <div id="Card" class="subsection">
                <h3>Card Details</h3>
                <div class="accordion">
                    <button class="accordion-btn" onclick="toggleAccordion(event)">Expand</button>
                    <div class="panel">
                        <p><strong>Card Number:</strong> <span id="card-number">**** **** **** 1234</span></p>
                        <p><strong>Expiration Date:</strong> <span id="expiration-date">MM/YY</span></p>
                        <p><strong>Card Type:</strong> <span id="card-type">Visa</span></p>
                    </div>
                </div>
            </div>

        </div>

        <div id="Shopping" class="tab-content">
        
            <!-- Example Order 1 -->
            <!-- <div class="order">
                <div class="order-header">
                    <p><strong>Order ID:</strong> <span>12345</span></p>
                    <p><strong>Order Date:</strong> <span>June 10, 2024</span></p>
                    <p><strong>Total Amount:</strong> <span>$150.00</span></p>
                    <p><strong>Order Status:</strong> <span>Ordered</span></p>
                </div>
                <button class="accordion-btn" onclick="toggleAccordion(event)">Expand</button>
                <div class="order-details">
                    Sample Item Details for Order 1
                    <div class="order-item">
                        <p><strong>Product Name:</strong> Truck Engine</p>
                        <p><strong>Quantity:</strong> 1</p>
                        <p><strong>Final Price:</strong> $150.00</p>
                    </div>
                    <div class="order-item">
                        <p><strong>Product Name:</strong> Brake Pads</p>
                        <p><strong>Quantity:</strong> 2</p>
                        <p><strong>Final Price:</strong> $50.00</p>
                    </div>
                </div>
            </div> -->


            <!-- Example Order 2 -->
            <!-- <div class="order">
                <div class="order-header">
                    <p><strong>Order ID:</strong> <span>54321</span></p>
                    <p><strong>Order Date:</strong> <span>June 5, 2024</span></p>
                    <p><strong>Total Amount:</strong> <span>$75.50</span></p>
                    <p><strong>Order Status:</strong> <span>Ready</span></p>
                </div>
                <button class="accordion-btn" onclick="toggleAccordion(event)">Expand</button>
                <div class="order-details">
                    Sample Item Details for Order 2
                    <div class="order-item">
                        <p><strong>Product Name:</strong> Headlights</p>
                        <p><strong>Quantity:</strong> 1</p>
                        <p><strong>Final Price:</strong> $25.50</p>
                    </div>
                    <div class="order-item">
                        <p><strong>Product Name:</strong> Oil Filters</p>
                        <p><strong>Quantity:</strong> 3</p>
                        <p><strong>Final Price:</strong> $50.00</p>
                    </div>
                </div>
            </div> -->

        </div>

        <div id="Settings" class="tab-content">
                <button id="delete-account-btn">Delete Account</button>
        </div>

        <hr> <!-- Horizontal line for separation -->
        <button id="logout-btn" class="logout-btn" onclick="logout()">Logout</button>

    </div>

    <script src="resources/scripts/profile_scripts/script.js"></script>


</body>
</html>