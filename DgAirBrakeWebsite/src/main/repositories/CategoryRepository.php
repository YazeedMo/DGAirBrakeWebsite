<?php

    require_once __DIR__ . '/../../main/model/Category.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

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
                    $row['CategoryName']
                );
                $category->setCategoryID($row['CategoryID']);

                $allCategories[] = $category;
            }

            return $allCategories;

        }

        public function getCategoryBYID($categoryID) {

            $sql = "SELECT * FROM Categories WHERE CategoryID = :categoryId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'categoryId' => $categoryID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $category = new Category(
                    $row['CategoryName']
                );
                $category->setCategoryID($row['CategoryID']);

                return $category;

            }

        }

        public function createCategory($category) {

            $sql = "INSERT INTO Categories (CategoryName)
                    VALUES (:categoryName)";
            
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'categoryName' => $category->getCategoryName()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getCategoryBYID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

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