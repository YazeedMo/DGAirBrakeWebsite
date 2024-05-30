<?php

require_once __DIR__ . '/../Repository/DAO/ProductRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {


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
else {
    echo json_encode(['error' => 'Invalid action']);
    http_response_code(400);
}

function getAllProducts() {

    $productRepo = new ProductRepository;

    return json_encode($productRepo->getAllProducts());

}

?>
