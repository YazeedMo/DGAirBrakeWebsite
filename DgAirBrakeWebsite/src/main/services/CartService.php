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


        public function addItemToCart($customer, $item) {

            $customerCart = $this->getCustomerCart($customer);

            if (!$customerCart) {
                $customerCart = $this->createCustomerCart($customer);
            }
            else {

                $cartItem = new CartItem(
                    $customerCart->getCartID(),
                    $item->getProductID(),
                    1);
            
                $this->cartItemRepo->createCartItem($cartItem);

            }
        }

        public function getCustomerCart($customer) {

            return $this->cartRepo->getCartByCustomerID($customer->getCustomerID());

        }

        public function createCustomerCart($customer) {

            $newCart = new Cart($customer->getCustomerID());

            return $this->cartRepo->createCart($newCart);

        }

    }

?>