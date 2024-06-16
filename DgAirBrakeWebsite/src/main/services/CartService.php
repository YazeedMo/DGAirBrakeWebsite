<?php

    require_once __DIR__ . '/../../main/model/CartItem.php';
    require_once __DIR__ . '/../../main/model/Cart.php';
    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ . '/../../main/repositories/CartRepository.php';
    require_once __DIR__ . '/../../main/repositories/CartItemRepository.php';

    class CartService {

        private $cartRepo;
        private $cartItemRepo;

        public function __construct() {
            $this->cartRepo = new CartRepository;
            $this->cartItemRepo = new CartItemRepository;            
        }


        public function addProductToCart($customer, $product) {

            $customerCart = $this->getCustomerCart($customer);

            $cartItem = $this->cartRepo->getCartItemByProductAndCartID($product->getProductID(), $customerCart->getCartID());

            if ($cartItem === null) {
                $cartItem = new CartItem(
                    $customerCart->getCartID(),
                    $product->getProductID(),
                    1);
                
                $this->cartItemRepo->createCartItem($cartItem);
            }
            else {
                $cartItem->setQuantity($cartItem->getQuantity() + 1);
                $this->cartItemRepo->updateCartItem($cartItem);
            }

        }

        public function getCustomerCart($customer) {

            return $this->cartRepo->getCartByCustomerID($customer->getCustomerID());

        }

        public function createCustomerCart($customer) {

            $newCart = new Cart($customer->getCustomerID());

            return $this->cartRepo->createCart($newCart);

        }

        public function getDetailedCartItemsByCustomerID($customer) {

            return $this->cartRepo->getDetailedCartItemsByCustomerID($customer->getCustomerID());

        }

        public function updateCartItemQuantity($cartItemID, $quantity) {

            return $this->cartItemRepo->updateCartItemQuantity($cartItemID, $quantity);

        }

        public function deleteCartItem($cartItemID) {

            return $this->cartItemRepo->deleteCartItem($cartItemID);
        }

    }

?>