<?php

    class Card {

        private $cardID;
        private $cardNumber;
        private $expirationDate;
        private $cardType;

        public function __construct($cardID, $cardNumber, $expirationDate, $cardType) {

            $this->cardID = $cardID;
            $this->cardNumber = $cardNumber;
            $this->expirationDate = $expirationDate;
            $this->cardType = $cardType;
            
        }

        public function getCardID() {
            return $this->cardID;
        }

        public function getCardNumber() {
            return $this->cardNumber;
        }

        public function getExpirationDate() {
            return $this->expirationDate;
        }

        public function getCardType() {
            return $this->cardType;
        }

        public function setCardID($cardID) {
            $this->cardID = $cardID;
        }

        public function setcardNumber($cardNumber) {
            $this->cardNumber = $cardNumber;
        }

        public function setExpirationDate($expirationDate) {
            $this->expirationDate = $expirationDate;
        }

        public function setCardType($cardType) {
            $this->cardType = $cardType;
        }

        public function __toString() {

            $desc = "$this->cardID<br>
                     $this->cardNumber<br>
                     $this->expirationDate<br>
                     $this->cardType<br>";

            return $desc;
        }

    }

?>