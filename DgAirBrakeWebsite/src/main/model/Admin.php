<?php

    require_once 'User.php';

    class Admin extends User implements JsonSerializable {

        private $adminID;

        public function __construct($username, $password, $email) {

            parent::__construct($username, $password, $email, 'Admin');
            
        }

        public function getAdminID() {
            return $this->adminID;
        }

        public function setAdminID($adminID) {
            $this->adminID = $adminID;
        }

        public function jsonSerialize() {

            $json = parent::jsonSerialize();

            $json['adminID'] = $this->getAdminID();

            return $json;

        }
 
        public function __toString() {
            $desc = "$this->adminID<br>" . parent::__toString();
            return $desc;
        }

    }


?>