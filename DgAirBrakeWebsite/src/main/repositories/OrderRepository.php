<?php

    require_once __DIR__ . '/../../main/model/Order.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

    class OrderRepository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();
        }

        public function getAllOrders() {

            $allOrders = array();

            $query = "SELECT * FROM Orders";

            $result = $this->dbConnection->query($query);
            while ($row = $result->fetch()) {
                $order = new Order(
                    $row['CustomerID'],
                    $row['OrderDate'],
                    $row['TotalAmount'],
                    $row['OrderStatus']
                );
                $order->setOrderID($row['OrderID']);

                $allOrders[] = $order;
            }

            return $allOrders;

        }

        public function getOrderByID($orderID) {

            $sql = "SELECT * FROM Orders WHERE OrderID = :orderId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'orderId' => $orderID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $order = new Order(
                    $row['CustomerID'],
                    $row['OrderDate'],
                    $row['TotalAmount'],
                    $row['OrderStatus']
                );
                $order->setOrderID($row['OrderID']);

                return $order;

            }

        }

        public function createOrder($order) {

            $sql = "INSERT INTO Orders (CustomerID, OrderDate, TotalAmount, OrderStatus)
                    VALUES (:customerId, :orderDate, :totalAmount, :orderStatus)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'customerId' => $order->getCustomerID(),
                'orderDate' => $order->getOrderDate(),
                'totalAmount' => $order->getTotalAmount(),
                'orderStatus' => $order->getOrderStatus()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getOrderByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        public function updateOrder($order) {

            $sql = "UPDATE Orders SET
                    CustomerID = :customerId,
                    OrderDate = :orderDate,
                    TotalAmount = :totalAmount,
                    OrderStatus = :orderStatus,
                    WHERE
                    OrderID = :orderId";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'customerId' => $order->getCustomerID(),
                'orderDate' => $order->getOrderDate(),
                'totalAmount' => $order->getTotalAmount(),
                'orderStatus' => $order->getOrderStatus()
            ]);

        }

        public function deleteOrder($orderID) {

            $sql = "DELETE FROM Orders WHERE OrderID = :orderId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'orderId' => $orderID
            ]);

        }

        public function makeOrder($customerID) {

            $sql = "CALL Checkout(:customerId)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'customerId' => $customerID
            ]);

        }

        public function getAllCustomerOrders($customerID) {

            $allOrders = array();
        
            $sql = "SELECT * FROM Orders WHERE CustomerID = :customerId";
        
            $stmt = $this->dbConnection->prepare($sql);
            
            if ($stmt->execute(['customerId' => $customerID])) {
                while ($row = $stmt->fetch()) {
                    $order = new Order(
                        $row['CustomerID'],
                        $row['OrderDate'],
                        $row['TotalAmount'],
                        $row['OrderStatus']
                    );
                    $order->setOrderID($row['OrderID']);
        
                    $allOrders[] = $order;
                }
            } else {
                // Handle query failure
                throw new Exception("Database query error");
            }
        
            return $allOrders;
        }
        

    }


?>