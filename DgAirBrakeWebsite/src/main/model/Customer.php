<?php

    require_once 'User.php';

    class Customer extends User implements JsonSerializable {

        private $customerID;
        private $cardID;

        public function __construct($username, $password, $email, $cardID) {

            parent::__construct($username, $password, $email, 'Customer');

            $this->cardID = $cardID;
            
        }

        public function getCustomerID() {
            return $this->customerID;
        }

        public function getCardID() {
            return $this->cardID;
        }

        public function setCustomerID($customerID) {
            $this->customerID = $customerID;
        }

        public function seCardID($cardID) {
            $this->cardID = $cardID;
        }

        public function jsonSerialize() {

            $json = parent::jsonSerialize();

            $json['customerID'] = $this->getCustomerID();
            $json['cardID'] = $this->getcardID();

            return $json;

        }

        public function __toString() {
            
            $desc = "$this->customerID<br>" . parent::__toString();
            $desc = $desc . "$this->cardID<br>";

            return $desc;

        }

    }

?>