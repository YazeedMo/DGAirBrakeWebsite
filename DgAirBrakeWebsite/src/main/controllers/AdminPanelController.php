<?php

    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/util/Session.php';
    require_once __DIR__ . '/../../main/services/ProductService.php';
    require_once __DIR__ . '/../../main/model/Product.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'logout':
                logout();
                break;
            case 'getAllProducts':
                getAllProducts();
                break;
            case 'getProductByID':
                getProductByID();
                break;
            case 'deleteProductByID':
                deleteProductByID();
                break;

        }

    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'addProduct':
                addProduct();
                break;
            case 'editProduct':
                editProduct();
                break;
        }

    }


    function logout() {

        unsetSessionVariable('currentUser');

        echo json_encode(['redirectUrl' => 'index.php']);

    }

    function getAllProducts() {

        $productService = new ProductService;

        $allProducts = $productService->getAllProducts();

        header('Content-Type: application/json');
        echo json_encode($allProducts);

    }

    function getProductByID() {

        $productService = new ProductService;

        $productID = $_GET['productId'];

        echo json_encode($productService->getProductByID($productID));

    }

    function addProduct() {

        $productName = $_POST['productName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantityAvailable = $_POST['quantityAvailable'];
        $file = $_FILES['fileToUpload'];

        if (!storeImage($file)) {
            echo json_encode(['message' => 'failed']);
            return;
        }
        else {
            $productService = new ProductService;

            $productService->addNewProduct($productName, $description, $price, $quantityAvailable, $file['name']);

            echo json_encode(['message' => 'sucess']);
        }
    }

    function editProduct() {

        $productService = new ProductService;

        $productToUpdate = $productService->getProductByID($_POST['productId']);

        // New image update
        if (isset($_POST['fileExist']) && $_POST['fileExist'] !== 'false') {

            $newFile = $_FILES['fileToUpload'];

            // Store image
            if (!storeImage($newFile)) {
                echo json_encode(['message' => 'failed']);
                return;
            }

            $productToUpdate->setImageURL($newFile['name']);
        }
        // No new image
        else {

            $originalImageURL = $productToUpdate->getImageURL();
            $fileName = basename($originalImageURL);

            $productToUpdate->setImageURL($fileName);
        
        }

        $productToUpdate->setProductName($_POST['productName']);
        $productToUpdate->setDescription($_POST['description']);
        $productToUpdate->setPrice($_POST['price']);
        $productToUpdate->setQuantityAvailable($_POST['quantityAvailable']);

        $productService->updateProduct($productToUpdate);

        echo json_encode(['message' => 'success']);

    }

    function storeImage($file) {

        $targetDir = "../../../resources/images/products/";

        $fileName = basename($file['name']);

        $targetFile = $targetDir . $fileName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return true;
        }
        else {
            return false;
        }

    }

    function deleteProductByID() {

        $productId = $_GET['productId'];

        $productService = new ProductService;

        $productService->deleteProductByID($productId);

        echo json_encode(['message' => 'success']);

    }

?>