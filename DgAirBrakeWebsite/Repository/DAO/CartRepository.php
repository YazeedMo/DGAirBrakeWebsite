<?php

    require_once __DIR__ . '/../DatabaseConnection.php';
    require_once __DIR__ . '/../../Model/Cart.php';

    class CartRepository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllCarts() {

            $allCarts = array();

            $query = "SELECT * FROM Carts";

            $result = $this->dbConnection->query($query);
            while ($row = $result->fetch()) {
                $cart = new Cart(
                    $row['CartID'],
                    $row['CustomerID']
                );

                $allCarts[] = $cart;
            }

            return $allCarts;

        }

        public function createCart($cart) {

            $sql = "INSERT INTO Carts (CartID, CustomerID)
                    VALUES (:cartId, :customerId)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartId' => $cart->getCartID(),
                'customerId' => $cart->getCustomerId()
            ]);

        }

        public function updateCart($cart) {

            $sql = "UPDATE Carts SET
                    CustomerID = :customerId
                    WHERE
                    CartID = :cartID";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'customerId' => $cart->getCustomerID(),
                'cartId' => $cart->getCartID()
            ]);
        }

        public function deleteCart($cartID) {

            $sql = "DELETE FROM Carts WHERE CartID = :cartId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartId' => $cartID
            ]);
        }
    }

?>