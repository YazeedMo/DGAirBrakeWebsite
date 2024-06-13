<?php

    require_once __DIR__ . '/../../main/model/CartItem.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

    class CartItemRepository {
        
        private $dbConnection;

        public function __construct() {

            $this->dbConnection = DatabaseConnection::getInstance();
            
        }

        public function getAllCartItems() {

            $allCartItems = array();

            $query = "SELECT * FROM CartItems";

            $result = $this->dbConnection->query($query);
            while ($row = $result->fetch()) {
                $cartItem = new CartItem(
                    $row['CartID'],
                    $row['ProductID'],
                    $row['Quantity']
                );
                $cartItem->setCartItemID($row['CartItemID']);

                $allCartItems[] = $cartItem;
            }

            return $allCartItems;

        }

        public function getCartItemByID($cartItemID) {

            $sql = "SELECT * FROM CartItems WHERE CartItemID = :cartItemId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'cartItemId' => $cartItemID
            ]);
            
            $row = $stmt->fetch();

            if ($row) {

                $cartItem = new CartItem(
                    $row['CartID'],
                    $row['ProductID'],
                    $row['Quantity']
                );
                $cartItem->setCartItemID($row['CartItemID']);

                return $cartItem;

            }

        }

        public function createCartItem($cartItem) {

            $sql = "INSERT INTO CartItems
                    (CartID, ProductID, Quantity)
                    VALUES
                    (:cartId, :productId, :quantity)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'cartId' => $cartItem->getCartID(),
                'productId' => $cartItem->getProductID(),
                'quantity' => $cartItem->getQuantity()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getCartItemByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        public function updateCartItem($cartItem) {

            $sql = "UPDATE CartItems set
                    CartID = :cartId,
                    ProductID = :productId,
                    Quantity = :quantity
                    WHERE CartItemID = :cartItemId";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartId' => $cartItem->getCartID(),
                'productId' => $cartItem->getProductID(),
                'quantity' => $cartItem->getQuantity(),
                'cartItemId' => $cartItem->getCartItemID()
            ]);

        }

        public function deleteCartItem($cartItemID) {

            $sql = "DELETE FROM CartItems
                    WHERE
                    CartID = :cartId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartId' => $cartItemID
            ]);

        }
        
    }

?>