<?php

    class Cart {

        private $cartID;
        private $customerID;

        public function __construct($cartID, $customerID) {
            
            $this->cartID = $cartID;
            $this->customerID = $customerID;

        }

        // Getters
        public function getCartID() {
            return $this->cartID;
        }

        public function getCustomerID() {
            return $this->customerID;
        }

        // Setters
        public function setCartID($cartID) {
            $this->cartID = $cartID;
        }

        public function setCustomerID($customerID) {
            $this->customerID = $customerID;
        }

        public function __toString() {

            $desc = "$this->cartID<br>
                     $this->customerID<br>";

            return $desc;
            
        }

    }

?>