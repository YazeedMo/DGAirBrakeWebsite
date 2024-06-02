<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ .  '/../../main/config/DatabaseConnection.php';

    abstract class UserRepository {

        protected $dbConnection;

        public function __construct() {

            $this->dbConnection = DatabaseConnection::getInstance();
            
        }

        public function getUserByID($userID) {

            $sql = "SELECT * FROM Users WHERE UserID = :userID";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(['userID' => $userID]);
            $row = $stmt->fetch();

            if ($row) {

                if ($row['Role'] === 'Admin') {
                    $user = new Admin(
                        $row['Username'],
                        $row['Password'],
                        $row['Email']
                    );
                    $user->setUserID($row['UserID']);
                    $user->setAdminID($row['AdminID']);

                    return $user;
                }
                else if ($row['Role'] === 'Customer') {
                    $user = new Customer(
                        $row['Username'],
                        $row['Password'],
                        $row['Email'],
                        $row['CardID']
                    );
                    $user->setUserID($row['UserID']);
                    $user->setCustomerID($row['CustomerID']);

                }

            }

            return null;

        }

        public function getUserByUsername($username) {

            $sql = "SELECT * FROM Users WHERE Username = :username";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(['username' => $username]);
            $row = $stmt->fetch();

            if ($row) {

                if ($row['Role'] === 'Admin') {
                    return $this->getAdminByUsername($username);
                }
                elseif ($row['Role'] === 'Customer') {
                    return $this->getCustomerByUsername($username);
                }
            }

            return null;

        }

        public function deleteUserByID($userID) {

            $sql = "CALL DeleteUser(:userId)";

            $stmt = $this->dbConnection->prepare($sql);

            return $stmt->execute([
                'userId' => $userID
            ]);

        }

        private function getAdminByUsername($username) {

            $sql = "SELECT * FROM Users_Admins WHERE Username = :username";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(['username' => $username]);

            $row = $stmt->fetch();

            if ($row) {

                $user = new Admin(
                    $row['Username'],
                    $row['Password'],
                    $row['Email']
                );
                $user->setUserID($row['UserID']);
                $user->setAdminID($row['AdminID']);

                return $user;

            }

        }

        private function getCustomerByUsername($username) {

            $sql = "SELECT * FROM Users_Customers WHERE Username = :username";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(['username' => $username]);

            $row = $stmt->fetch();

            if ($row) {

                $user = new Customer(
                    $row['Username'],
                    $row['Password'],
                    $row['Email'],
                    $row['CardID']
                );
                $user->setUserID($row['UserID']);
                $user->setCustomerID($row['CustomerID']);

                return $user;

            }

        }

    }


?>