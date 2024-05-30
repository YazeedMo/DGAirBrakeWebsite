<?php

    class Address implements JsonSerializable {

        private $addressID;
        private $addressString;
        private $areaCode;

        public function __construct($addressID, $addressString, $areaCode) {
            $this->addressID = $addressID;
            $this->addressString = $addressString;
            $this->areaCode = $areaCode;
        }

        public function getAddressID() {
            return $this->addressID;
        }

        public function getAddressString() {
            return $this->addressString;
        }

        public function getAreaCode() {
            return $this->areaCode;
        }

        public function setAddressID($addressID) {
            $this->addressID = $addressID;
        }

        public function setAddressString($addressString) {
            $this->addressString = $addressString;
        }

        public function setAreaCode($areaCode) {
            $this->areaCode = $areaCode;
        }

        public function jsonSerialize() {

            return [
                'addressID' => $this->getAddressID(),
                'addressString' => $this->getAddressString(),
                'areaCode' => $this->getAreaCode()
            ];

        }

        public function __toString() {
            
            $desc = "$this->addressID<br>
                     $this->addressString<br>
                     $this->areaCode<br>";
            
            return $desc;

        }

    }

?>