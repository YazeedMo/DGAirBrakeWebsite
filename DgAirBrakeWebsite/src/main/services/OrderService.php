<?php

    require_once __DIR__ . '/../../main/model/CartItem.php';
    require_once __DIR__ . '/../../main/model/Cart.php';
    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ . '/../../main/repositories/CartRepository.php';
    require_once __DIR__ . '/../../main/repositories/CartItemRepository.php';
    require_once __DIR__ . '/../../main/repositories/OrderRepository.php';
    require_once __DIR__ . '/../../main/util/Session.php';

    class OrderService {

        private $orderRepo;

        public function __construct() {
            
            $this->orderRepo = new OrderRepository;

        }

        public function checkout() {

            $this->orderRepo->makeOrder(getSessionCurrentUser()->getCustomerID());


        }

        public function getAllCustomerOrders() {

            return $this->orderRepo->getAllCustomerOrders(getSessionCurrentUser()->getCustomerID());
            
        }



    }

?>