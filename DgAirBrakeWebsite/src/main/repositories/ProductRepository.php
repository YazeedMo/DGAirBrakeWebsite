<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Product.php';

    class ProductRepository {

        private $dbConnection;

        public function __construct() {

            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllProducts() {

            $allProducts = array();

            $query = "SELECT * FROM Products";
            $result = $this->dbConnection->query($query);

            while ($row = $result->fetch()) {
                $product = new Product(
                    $row['ProductID'],
                    $row['ProductName'],
                    $row['Description'],
                    $row['Price'],
                    $row['QuantityAvailable'],
                    $row['ImageURL']
                );

                $allProducts[] = $product;

            }

            return $allProducts;

        }

        public function createProduct($product) {

            $stmt = $this->dbConnection->prepare("INSERT INTO Products (ProductID, ProductName, Description, Price, QuantityAvailable, ImageURL) VALUES (:productId, :productName, :description, :price, :quantityAvailable, :imageUrl)");
            return $stmt->execute([
                'productId' => $product->getProductID(),
                'productName' => $product->getProductName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'quantityAvailable' => $product->getQuantityAvailable(),
                'imageUrl' => $product->getImageURL()
            ]);

        }

        public function updateProduct($product) {

            $sql = "UPDATE PRODUCTS
                      SET
                      ProductName = :productName,
                      Description = :description,
                      Price = :price,
                      QuantityAvailable = :quantityAvailable,
                      ImageURL = :imageUrl
                      WHERE ProductID = :productId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'productName' => $product->getProductName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'quantityAvailable' => $product->getQuantityAvailable(),
                'imageUrl' => $product->getImageURL(),
                'productId' => $product->getProductID()
            ]);

        }

        public function deleteProduct($product) {

            $sql = "DELETE FROM Products
                    WHERE ProductID = :productId";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'productId' => $product->getProductID()
            ]);

        }
    }

?>