<?php

    require_once __DIR__ .  '/../DatabaseConnection.php';
    require_once __DIR__ . '/../../Model/User.php';
    require_once __DIR__ . '/../../Model/Customer.php';

    abstract class UserRepository {

        protected $dbConnection;

        public function __construct() {

            $this->dbConnection = DatabaseConnection::getInstance();
            
        }

        public function getUserByID($userID) {

            $stmt = $this->dbConnection->prepare("SELECT * FROM Users WHERE UserID = :userID");
            $stmt->execute(['userID' => $userID]);
            $row = $stmt->fetch();

            if ($row) {

                if ($row['Role'] === 'Admin') {
                    $user = new Admin(
                        $row['AdminID'],
                        $row['UserID'],
                        $row['Username'],
                        $row['Password'],
                        $row['Email']
                    );

                    $user->setUserID($row['UserID']);

                    return $user;
                }

                // Add logic for returning a Customer
            }

            return null;

        }

        public function getUserByUsername($username) {

            $stmt = $this->dbConnection->prepare("SELECT * FROM Users WHERE Username = :username");
            $stmt->execute(['username' => $username]);
            $row = $stmt->fetch();

            if ($row) {

                if ($row['Role'] === 'Admin') {
                    $user = new Admin(
                        $row['AdminID'],
                        $row['userID'],
                        $row['Username'],
                        $row['Password'],
                        $row['Email']
                    );

                    $user->setUserID($row['UserID']);

                    return $user;
                }

                // Add logic for returning a Customer
            }

            return null;

        }

        public function deleteUserByID($userID) {

            $stmt = $this->dbConnection->prepare("CALL DeleteUser(:userId)");

            return $stmt->execute([
                'userId' => $userID
            ]);

        }

    }


?>