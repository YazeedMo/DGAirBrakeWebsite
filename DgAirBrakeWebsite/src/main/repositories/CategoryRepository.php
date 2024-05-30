<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Category.php';

    class CategoryRepository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllCategories() {

            $allCategories = array();
            
            $query = "SELECT * FROM Categories";
            $result = $this->dbConnection->query($query);

            while ($row = $result->fetch()) {
                $category = new Category(
                    $row['CategoryID'],
                    $row['CategoryName']
                );

                $allCategories[] = $category;
            }

            return $allCategories;

        }

        public function createCategory($category) {

            $sql = "INSERT INTO Categories (CategoryID, CategoryName)
                    VALUES (:categoryId, :categoryName)";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'categoryId' => $category->getCategoryID(),
                'categoryName' => $category->getCategoryName()
            ]);

        }

        public function updateCategory($category) {

            $sql = "UPDATE Categories SET
                    CategoryName = :categoryName
                    WHERE CategoryID = :categoryId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'categoryName' => $category->getCategoryName(),
                'categoryId' => $category->getCategoryID()
            ]);

        }

        public function deleteCategory($category) {

            // Delete from ProductCategories table first
            $sql = "DELETE FROM ProductCategories
                    WHERE CategoryID = :categoryId";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'categoryId' => $category->getCategoryID()
            ]);

            // Then delete from Categories table
            $sql = "DELETE FROM Categories
                    WHERE CategoryID = :categoryId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'categoryId' => $category->getCategoryID()
            ]);

        }

    }

?>