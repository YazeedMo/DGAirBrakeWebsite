<?php

    require_once __DIR__ . '../../model/Product.php';
    require_once __DIR__ . '../../services/ProductService.php';
    require_once __DIR__ . '../../util/Session.php';
    require_once __DIR__ . '../../services/CartService.php';
    require_once __DIR__ . '../../services/OrderService.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'getAllProducts':
                getAllProducts();
                break;
            case 'getProductsByKeyword':
                getProductsByKeyword();
                break;
            case 'getCartItems':
                getCartItems();
                break;
            case 'makeOrder':
                makeOrder();
                break;
        }

    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'addProductToCart':
                addProductToCart();
                break;
            case 'deleteCartItem':
                deleteCartItem();
                break;
            case 'updateCartItems':
                updateCartItems();
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

    function getCartItems() {

        $currentCustomer = getSessionCurrentUser();

        $cartService = new CartService;

        $detailedCartItems = $cartService->getDetailedCartItemsByCustomerID($currentCustomer);

        header('Content-type: application/json');
        echo json_encode($detailedCartItems);

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

    function deleteCartItem() {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data) {

            $cartItemID = $data['cartItemID'];
            
            $cartService = new CartService();

            $cartService->deleteCartItem($cartItemID);

            $response = [
                'status'=> 'success',
                'message' => 'product removed from cart'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;

        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

    }

    function updateCartItems() {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data) {

            $cartService = new CartService();

            foreach($data as $item) {
                $cartItemID = $item['cartItemID'];
                $quantity = $item['quantity'];
                
                $cartService->updateCartItemQuantity($cartItemID, $quantity);

                $response = [
                    'status'=> 'success',
                    'message' => 'Cart updated'
                ];

            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;

        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

    }

    function makeOrder() {

        $orderService = new OrderService;

        $orderService->checkout();

        echo json_encode(['message' => 'redirect', 'url' => 'profile.php']);

    }

?>