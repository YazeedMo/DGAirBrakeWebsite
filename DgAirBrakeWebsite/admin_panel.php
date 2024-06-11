<?php

    require_once __DIR__ . '/src/main/util/Session.php';
    require_once __DIR__ . '/src/main/model/User.php';
    require_once __DIR__ . '/src/main/model/Admin.php';
    require_once __DIR__ . '/src/main/model/Customer.php';

    $currentUser = false;
    $username = "Login";

    $currentUser = getSessionCurrentUser();

    if (!$currentUser === false) {
        $username = $currentUser->getUsername();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/styles/admin_panel_styles/style.css">
    <link rel="stylesheet" href="resources/styles/admin_panel_styles/add_product_modal.css">
    <title>Document</title>
</head>
<body>

    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                Admin Panel
            </div>
            <div class="sidebar-menu" id="manage-products-btn" onclick="changeView('manage-products-view')">
                Manage Products
            </div>
            <div class="sidebar-menu" id="manage-orders-btn" onclick="changeView('manage-orders-view')">
                Manage Orders
            </div>
        </div>
        <div class="main-area">
            <div class="top-bar">
                <span id="testLabel">Hello, <?php echo $username?></span>
                <button id="logout-btn" onclick="logout()">Logout</button>
            </div>
            <div class="main-content">

                <div class="menu-view" id="manage-products-view">

                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ProdID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity Available</th>
                                <th>Image URL</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be inserted here -->
                        </tbody>
                    </table>
                    <button class="add-btn" id="add-new-product-btn" onclick="addProduct()">Add New Product</button>
                    <img id="image-preview">

                </div>

                <div class="menu-view" id="manage-orders-view" style="display: none;">

                    manager orders

                </div>

            </div>
        </div>
    </div>

</body>

<!-- Add Product Modal -->
<div class="modal" id="manage-product-modal" style="display: none;">

    <div class="modal-content">

        <span class="close">&times;</span>
        <h2 id="modal-heading">Add New Product</h2>
        <p class="notification" id="notification-label" style="display: none;">This is a notification message</p>

        <form id="add-product-form" enctype="multipart/form-data" onsubmit="submitForm(event)">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="product-name" name="product-name">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price">
            </div>
            <div class="form-group">
                <label for="quantity-available">Quantity Available:</label>
                <input type="number" id="quantity-available" name="quantity-available">
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
            </div>
            <button class="submit-btn" id="edit-product-btn">Edit Product</button>
            <button class="submit-btn" id="add-product-btn">Add Product</button>
            <button class="submit-btn" id="delete-product-btn" style="background-color: red;">Delete Product</button>
        </form>

    </div>

</div>

<script src="resources/scripts/admin_panel_scripts/script.js"></script>
<script src="resources/scripts/admin_panel_scripts/manage_products
.js"></script>

</html>