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
                    $row['ProductName'],
                    $row['Description'],
                    $row['Price'],
                    $row['QuantityAvailable'],
                    $row['ImageURL']
                );
                $product->setProductID($row['ProductID']);

                $allProducts[] = $product;

            }

            return $allProducts;

        }

        public function getProductByID($productID) {

            $sql = "SELECT * FROM Products WHERE ProductID = :productId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'productId' => $productID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $product = new Product(
                    $row['ProductName'],
                    $row['Description'],
                    $row['Price'],
                    $row['QuantityAvailable'],
                    $row['ImageURL']
                );
                $product->setProductID($row['ProductID']);

                return $product;

            }

        }

        public function createProduct($product) {

            $sql = "INSERT INTO Products
                    (ProductName, Description, Price, QuantityAvailable, ImageURL)
                    VALUES (:productName, :description, :price, :quantityAvailable, :imageUrl)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'productName' => $product->getProductName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'quantityAvailable' => $product->getQuantityAvailable(),
                'imageUrl' => $product->getImageURL()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getProductByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

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