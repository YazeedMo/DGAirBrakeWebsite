<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/repositories/UserRepository.php';

    class CustomerRepository extends UserRepository {

        public function __construct() {
            parent::__construct();
        }

        public function getAllCustomers() {

            $allCustomers = array();

            $query = "SELECT * FROM Users_Customers";
            $result = $this->dbConnection->query($query);

            while ($row = $result->fetch()) {

                $customer = new Customer(
                    $row['Username'],
                    $row['Password'],
                    $row['AddressID'],
                    $row['CardNumber']
                );
                $customer->setUserID($row['UserID']);
                $customer->setCustomerID($row['CustomerID']);

                $allCustomers[] = $customer;
            }

            return $allCustomers;

        }

        public function getCustomerByID($customerID) {

            $sql = "SELECT * FROM Users_Customers WHERE CustomerID = :customerId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'customerId'
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $customer = new Customer(
                    $row['Username'],
                    $row['Password'],
                    $row['Email'],
                    $row['CardID']
                );
                $customer->setCustomerID($row['CustomerID']);

                return $customer;

            }

        }

        public function createCustomer($customer) {

            $sql = "CALL AddCustomer(:username, :password, :email, :cardId)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'username' => $customer->getUsername(),
                'password' => $customer->getPassword(),
                'email' => $customer->getEmail(),
                'cardId' => $customer->getCardID()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getCustomerByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        public function updateCustomer($customer) {

            $sql = "CALL UpdateCustomer(:userId, :customerId, :username, :password, :email, :cardNumber)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'userId' => $customer->getUserID(),
                'customerId' => $customer->getCustomerID(),
                'username' => $customer->getUserame(),
                'password' => $customer->getPassword(),
                'email' => $customer->getEmail(),
                'cardNumber' => $customer->getCardNumber()
            ]);

        }

    }

?>