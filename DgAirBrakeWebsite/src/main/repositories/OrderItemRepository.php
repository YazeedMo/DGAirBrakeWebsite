<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/CartItem.php';

    class OrderItemRepository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllOrderItems() {

            $allOrderitems = array();

            $query = "SELECT * FROM OrderItems";

            $result = $this->dbConnection->query($query);
            while ($row = $result->fetch()) {
                $orderItem = new OrderItem(
                    $row['OrderItemID'],
                    $row['OrderID'],
                    $row['ProductID'],
                    $row['Quantity'],
                    $row['Price']
                );

                $allOrderitems[] = $orderItem;
            }

            return $allOrderitems;
        }

        public function createOrderItem($orderItem) {

            $sql = "INSERT INTO OrderItems (OrderItemID, OrderID, ProductID, Quantity, Price)
                    VALUES (:orderItemId, :orderId, :productId, :quantity, :price)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'orderItemId' => $orderItem->getOrderItemID(),
                'orderId' => $orderItem->getOrderID(),
                'productId' => $orderItem->getProductID(),
                'quantity' => $orderItem->getQuantity(),
                'price' => $orderItem->getPrice()
            ]);

        }

        public function updateOrderItem($orderItem) {

            $sql = "UPDATE OrderItems SET
                    OrderID = :orderId, 
                    ProductID = :productId, 
                    Quantity = :quantity,
                    Price = :price
                    WHERE OrderItemID = :orderItemId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'orderItemId' => $orderItem->getOrderItemID(),
                'orderId' => $orderItem->getOrderID(),
                'productId' => $orderItem->getProductID(),
                'quantity' => $orderItem->getQuantity(),
                'price' => $orderItem->getPrice()
            ]);

        }

        public function deleteOrderItem($orderItemID) {

            $sql = "DELETE FROM OrderItems WHERE OrderItemID = :orderItemId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'orderItemId' => $orderItemID
            ]);

        }

    }

?>