<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Product.php';

    class ProductRepository {

        private $dbConnection;

        public function __construct() {

            $this->dbConnection = DatabaseConnection::getInstance();

        }

        // Returns all products
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

        // Returns a Product by the given ID
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

        // Adds the given Product to the database
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
                'imageUrl' => 'resources/images/products/' . $product->getImageURL()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getProductByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        // Updates the given Product in the database
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
                'imageUrl' => 'resources/images/products/' . $product->getImageURL(),
                'productId' => $product->getProductID()
            ]);

        }

        // Removes the given product from the database
        public function deleteProduct($product) {

            $sql = "DELETE FROM Products
                    WHERE ProductID = :productId";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'productId' => $product->getProductID()
            ]);

        }

        // Removes a Product from the database by the given ID
        public function deleteProductByID($productId) {

            $sql = "DELETE FROM Products WHERE ProductID = :productId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'productId' => $productId
            ]);

        }

        // Returns Products with a Product Name matching the given key word
        public function getProductsByKeyword($keyword) {

            $allProducts = array();

            $sql = "SELECT * FROM Products WHERE ProductName LIKE :keyword";

            $stmt = $this->dbConnection->prepare($sql);
            
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);

            $stmt->execute();


            while ($row = $stmt->fetch()) {
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

    }

?>