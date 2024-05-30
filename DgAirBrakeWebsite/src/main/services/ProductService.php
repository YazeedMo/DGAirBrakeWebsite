<?php

    require_once __DIR__ . '/../../main/repositories/ProductRepository.php';
    require_once __DIR__ . '/../../main/model/Product.php';


    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        // echo 'in get checking';

        $action = $_GET['action'];
        
        switch ($action) {
            case 'getAllProducts':
                echo getAllProducts();
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                http_response_code(400);
                break;
        }

    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

        echo "in post checking";

        $action = $_POST['action'];

        switch($action) {
            case 'addProduct':
                echo addProduct();
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                http_response_code(400);
                break;
        }

    }
    else {
        echo 'in else statement';
        echo json_encode(['error' => 'Invalid action']);
        http_response_code(400);
    }

    function getAllProducts() {

        $productRepo = new ProductRepository;

        return json_encode($productRepo->getAllProducts());

    }

    function addProduct() {

        // Handle file upload
        // $target_dir = 'uploads/';
        // $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // move_uploaded_file($_FILES["image"]['tmp_name'], $target_file);

        $productRepo = new ProductRepository;
        $newProduct = new Product(12, 'new', 'very new', 34, 4, "image url");

        $productRepo->createProduct($newProduct);

    }

?>
