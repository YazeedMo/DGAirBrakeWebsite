<?php

    require_once __DIR__ . '/../../main/model/Cart.php';
    require_once __DIR__ . '/../../main/model/CartItem.php';
    require_once __DIR__ . '/../../main/model/Product.php';
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

            return null;

        }

        public function getCartByCustomerID($customerID) {

            $sql = "SELECT * FROM Carts WHERE CustomerID = :customerID";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'customerID' => $customerID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $cart = new Cart(
                    $row['CustomerID']
                );
                $cart->setCartID($row['CartID']);

                return $cart;

            }

            return false;

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

        public function getCartItemByProductAndCartID($productID, $cartID) {

            $sql = 'SELECT * FROM CartItems WHERE ProductID = :productId AND CartID = :cartId';

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'productId' => $productID,
                'cartId' => $cartID
            ]);

            $row = $stmt->fetch();

            if ($row) {
                $cartItem = new CartItem($row['CartID'], $row['ProductID'], $row['Quantity']);
                $cartItem->setCartItemID($row['CartItemID']);
                return $cartItem;
            }

            return null;

        }

        // Get all Product details from User cart
        public function getDetailedCartItemsByCustomerID($customerID) {

            $allCartItems = array();

            $sql = 'SELECT * FROM CustomerCartView WHERE CustomerID = :customerId';

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'customerId' => $customerID
            ]);

            while ($row = $stmt->fetch()) {

                $cartItemID = $row['CartItemID'];

                $product = new Product(
                    $row['ProductName'],
                    $row['Description'],
                    $row['Price'],
                    $row['QuantityAvailable'],
                    $row['ImageURL']);
                $product->setProductID($row['ProductID']);

                $quantity = $row['Quantity'];

                $totalPrice = $row['TotalPrice'];

                $detailedCartItem = new stdClass();
                $detailedCartItem->cartItemID = $cartItemID;
                $detailedCartItem->product = $product;
                $detailedCartItem->quantity = $quantity;
                $detailedCartItem->totalPrice = $totalPrice;

                $allCartItems[] = $detailedCartItem;

            }

            return $allCartItems;

        }

    }

?>