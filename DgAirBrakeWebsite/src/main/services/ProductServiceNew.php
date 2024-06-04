<?php

    require_once __DIR__ . '/../../main/model/Product.php';
    require_once __DIR__ . '/../../main/repositories/ProductRepository.php';

    class ProductService {

        private $productRepo;

        public function __construct() {
            $this->productRepo = new ProductRepository;
        }


        public function getAllProducts() {

            return $this->productRepo->getAllProducts();

        }

        public function addNewProduct($productName, $description, $price, $quantityAvailable, $imageUrl) {

            $newProduct = new Product($productName, $description, $price, $quantityAvailable, $imageUrl);

            $this->productRepo->createProduct($newProduct);

        }

    }

?>