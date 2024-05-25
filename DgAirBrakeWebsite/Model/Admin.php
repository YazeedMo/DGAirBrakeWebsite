<?php

    require_once 'User.php';

    class Admin extends User {

        private $adminID;

        public function __construct($adminID, $userID, $username, $password, $email) {

            parent::__construct($userID , $username, $password, $email, 'Admin');

            $this->adminID = $adminID;
            
        }

        public function getAdminID() {
            return $this->adminID;
        }

        public function setAdminID($adminID) {
            $this->adminID = $adminID;
        }

        public function __toString() {
            $desc = "$this->adminID<br>" . parent::__toString();
            return $desc;
        }

    }


?>