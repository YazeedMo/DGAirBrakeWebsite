<?php

    class CartItem implements JsonSerializable {

        private $cartItemID;
        private $cartID;
        private $productID;
        private $quantity;

        public function __construct($cartItemID, $cartID, $productID, $quantity) {
            
            $this->cartItemID = $cartItemID;
            $this->cartID = $cartID;
            $this->productID = $productID;
            $this->quantity = $quantity;

        }

        // Getters

        public function getCartItemID() {
            return $this->cartItemID;
        }

        public function getCartID() {
            return $this->cartID;
        }

        public function getProductID() {
            return $this->productID;
        }

        public function getQuantity() {
            return $this->quantity;
        }

        // Setters
        public function setCartItemID($cartItemID) {
            $this->cartItemID = $cartItemID;
        }

        public function setCartID($cartID) {
            $this->cartID = $cartID;
        }

        public function setProductID($productID) {
            $this->productID = $productID;
        }

        public function setQuantity($quantity) {
            $this->quantity = $quantity;
        }

        public function jsonSerialize() {

            return [
                'cartItemID' => $this->getCartItemID(),
                'cartID' => $this->getCartID(),
                'productID' => $this->getProductID(),
                'quantity' => $this->getQuantity()
            ];

        }

        public function __toString() {
            
            $desc = "$this->cartItemID<br>
                     $this->cartID<br>
                     $this->productID<br>
                     $this->quantity<br>";
            
            return $desc;

        }

    }

?>