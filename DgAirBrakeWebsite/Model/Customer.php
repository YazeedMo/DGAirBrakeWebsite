<?php

    require_once 'User.php';

    class Customer extends User {

        private $customerID;
        private $cardID;

        public function __construct($customerID, $userID, $username, $password, $email, $cardID) {

            parent::__construct($userID, $username, $password, $email, 'Customer');

            $this->customerID = $customerID;
            $this->cardID = $cardID;
            
        }

        public function getCustomerID() {
            return $this->customerID;
        }

        public function getcardID() {
            return $this->cardID;
        }

        public function setCustomerID($customerID) {
            $this->customerID = $customerID;
        }

        public function seCardID($cardID) {
            $this->cardID = $cardID;
        }

        public function __toString() {
            
            $desc = "$this->customerID<br>" . parent::__toString();
            $desc = $desc . "$this->cardID<br>";

            return $desc;

        }

    }

?>