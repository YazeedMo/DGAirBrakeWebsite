<?php

    require_once __DIR__ . '/../../main/model/Cart.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

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
                    $row['CustomerID']
                );
                $cart->setCartID($row['CartID']);

                $allCarts[] = $cart;
            }

            return $allCarts;

        }

        public function getCartByID($cartID) {

            $sql = "SELECT * FROM Carts WHERE CartID = :cartId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'cartId' => $cartID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $cart = new Cart(
                    $row['CustomerID']
                );
                $cart->setCartID($row['CartID']);

                return $cart;

            }

        }

        public function createCart($cart) {

            $sql = "INSERT INTO Carts (CustomerID)
                    VALUES (:customerId)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'customerId' => $cart->getCustomerId()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getCartByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

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