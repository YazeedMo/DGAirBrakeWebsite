<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Order.php';

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
                    $row['OrderID'],
                    $row['CustomerID'],
                    $row['OrderDate'],
                    $row['TotalAmount'],
                    $row['OrderStatus']
                );

                $allOrders[] = $order;
            }

            return $allOrders;

        }

        public function createOrder($order) {

            $sql = "INSERT INTO Orders (OrderID, CustomerID, OrderDate, TotalAmount, OrderStatus)
                    VALUES (:orderId, :customerId, :orderDate, :totalAmount, :orderStatus)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'orderId' => $order->getOrderID(),
                'customerId' => $order->getCustomerID(),
                'orderDate' => $order->getOrderDate(),
                'totalAmount' => $order->getTotalAmount(),
                'orderStatus' => $order->getOrderStatus()
            ]);

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

    }


?>