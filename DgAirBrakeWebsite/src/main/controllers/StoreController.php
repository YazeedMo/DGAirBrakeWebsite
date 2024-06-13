<?php

    require_once __DIR__ . '../../model/Product.php';
    require_once __DIR__ . '../../services/ProductService.php';
    require_once __DIR__ . '../../util/Session.php';
    require_once __DIR__ . '../../services/CartService.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'getAllProducts':
                getAllProducts();
                break;
            case 'getProductsByKeyword':
                getProductsByKeyword();
                break;
        }

    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'addProductToCart':
                addProductToCart();
                break;
        }

    }

    function getAllProducts() {

        $productService = new ProductService;

        $allProducts = $productService->getAllProducts();

        header('Content-Type: application/json');
        echo json_encode($allProducts);

    }

    function getProductsByKeyword() {

        $keyword = $_GET['keyword'];

        $productService = new ProductService;

        $allProducts = $productService->getProductsByKeyword($keyword);

        header('Content-type: application/json');
        echo json_encode($allProducts);

    }

    function addProductToCart() {

        $json = file_get_contents('php://input');
        $productData = json_decode($json, true);

        if ($productData) {
            $productID = $productData['productID'];
            $productName = $productData['productName'];
            $description = $productData['description'];
            $price = $productData['price'];
            $quantityAvailable = $productData['quantityAvailable'];
            $imageURL = $productData['imageURL'];

            $product = new Product(
                $productName,
                $description,
                $price,
                $quantityAvailable,
                $imageURL
            );
            $product->setProductID($productID);

            $customer = getSessionCurrentUser();

            $cartService = new CartService;

            $cartService->addProductToCart($customer, $product);

            $response = [
                'status' => 'success',
                'message' => 'product added to cart',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;

        } else {
            // Handle error if JSON decoding fails
            $response = [
                'status' => 'error',
                'message' => 'Invalid JSON data',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

    }

?>