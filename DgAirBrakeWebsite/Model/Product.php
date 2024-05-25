<?php

    class Product {
        private $productID;
        private $productName;
        private $description;
        private $price;
        private $quantityAvailable;
        private $imageURL;

        public function __construct($productID, $productName, $description, $price, $quantityAvailable, $imageURL) {
            $this->productID = $productID;
            $this->productName = $productName;
            $this->description = $description;
            $this->price = $price;
            $this->quantityAvailable = $quantityAvailable;
            $this->imageURL = $imageURL;
        }

        // Getter methods
        public function getProductID() {
            return $this->productID;
        }

        public function getProductName() {
            return $this->productName;
        }

        public function getDescription() {
            return $this->description;
        }

        public function getPrice() {
            return $this->price;
        }

        public function getQuantityAvailable() {
            return $this->quantityAvailable;
        }

        public function getImageURL() {
            return $this->imageURL;
        }

        // Setter methods
        public function setProductID($productID) {
            $this->productID = $productID;
        }

        public function setProductName($productName) {
            $this->productName = $productName;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function setQuantityAvailable($quantityAvailable) {
            $this->quantityAvailable = $quantityAvailable;
        }

        public function setImageURL($imageURL) {
            $this->imageURL = $imageURL;
        }

        public function __toString() {

            $desc = "$this->productID<br>
                     $this->productName<br>
                     $this->description<br>
                     $this->price<br>
                     $this->quantityAvailable<br>
                     $this->imageURL<br>";

            return $desc;
            
        }

    }

?>