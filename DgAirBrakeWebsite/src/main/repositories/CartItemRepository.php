<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/CartItem.php';


    class CartItem {
        
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
                    $row['CartItemID'],
                    $row['CartID'],
                    $row['ProductID'],
                    $row['Quantity']
            
                );
            
                $allCartItems[] = $cartItem;
            }

            return $allCartItems;

        }

        public function createCartItem($cartItem) {

            $sql = "INSERT INTO CartItems
                    (CartItemID, CartID, ProductID, Quantity)
                    VALUES
                    (:cartItemId, :cartId, :productId, :quantity)";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartItemId' => $cartItem->getCartItemID(),
                'cartId' => $cartItem->getCartID(),
                'productId' => $cartItem->getProductID(),
                'quantity' => $cartItem->getQuantity()
            ]);

        }

        public function updateCartItem($cartItem) {

            $sql = "UPDATE Carts set
                    CartID = :cartId,
                    ProductID = :productId,
                    Quantity = :quantity
                    WHERE CartItemID = :cartItemId";
            
            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cartId' => $cartItem->getCartID(),
                'productId' => $cartItem->getProductID(),
                'quantity' => $cartItem->getQuantity()
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