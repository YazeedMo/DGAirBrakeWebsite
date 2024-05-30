<?php

    abstract class User implements JsonSerializable {

        private $userID;
        private $username;
        private $password;
        private $email;
        private $role;

        public function __construct($userID, $username, $password, $email, $role) {
            
            $this->userID = $userID;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->role = $role;

        }

        public function getUserID() {
            return $this->userID;
        }
    
        public function getUsername() {
            return $this->username;
        }
    
        public function getPassword() {
            return $this->password;
        }
    
        public function getEmail() {
            return $this->email;
        }
    
        public function getRole() {
            return $this->role;
        }
    
        public function setUserID($userID) {
            $this->userID = $userID;
        }
    
        public function setUsername($username) {
            $this->username = $username;
        }
    
        public function setPassword($password) {
            $this->password = $password;
        }
    
        public function setEmail($email) {
            $this->email = $email;
        }
    
        public function setRole($role) {
            $this->role = $role;
        }

        public function jsonSerialize() {

            return [
                'userID' => $this->getUserID(),
                'username' => $this->getUsername(),
                'password' => $this->getPassword(),
                'email' => $this->getEmail(),
                'role' => $this->getRole()
            ];

        }

        public function __toString() {

            $desc = "$this->userID<br>
                     $this->username<br>
                     $this->password<br>
                     $this->email<br>
                     $this->role<br>";

            return $desc;
        }
    }

?>