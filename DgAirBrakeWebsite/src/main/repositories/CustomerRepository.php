<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
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
                    $row['CustomerID'],
                    $row['UserID'],
                    $row['Username'],
                    $row['Password'],
                    $row['AddressID'],
                    $row['CardNumber']
                );

                $allCustomers[] = $customer;
            }

            return $allCustomers;

        }

        public function createCustomer($customer) {

            $stmt = $this->dbConnection->prepare("CALL AddCustomer(:userId, :customerId, :username, :password, :email, :cardNumber)");
            return $stmt->execute([
                'userId' => $customer->getUserID(),
                'customerId' => $customer->getCustomerID(),
                'username' => $customer->getUserame(),
                'password' => $customer->getPassword(),
                'email' => $customer->getEmail(),
                'cardNumber' => $customer->getCardNumber()
            ]);

        }

        public function updateCustomer($customer) {

            $stmt = $this->dbConnection->prepare("CALL UpdateCustomer(:userId, :customerId, :username, :password, :email, :cardNumber)");
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