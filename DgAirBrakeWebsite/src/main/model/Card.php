<?php

    class Card implements JsonSerializable {

        private $cardID;
        private $cardNumber;
        private $expirationDate;
        private $cardType;

        public function __construct($cardNumber, $expirationDate, $cardType) {

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

        public function jsonSerialize() {

            return [
                'cardID' => $this->getCardID(),
                'cardNumber' => $this->getCardNumber(),
                'expirationDate' => $this->getExpirationDate(),
                'cardType' => $this->getCardType()
            ];

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