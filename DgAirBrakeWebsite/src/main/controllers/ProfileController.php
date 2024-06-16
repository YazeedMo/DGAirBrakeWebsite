<?php

    require_once __DIR__ . '/../../main/util/Session.php';
    require_once __DIR__ . '/../../main/services/UserService.php';
    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ . '/../../main/model/Address.php';
    require_once __DIR__ . '/../../main/model/Card.php';
    require_once __DIR__ . '/../../main/services/OrderService.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'logout':
                logout();
                break;
            case 'getCustomerDetails':
                getCustomerDetails();
                break;
            case 'getOrders':
                getOrders();
                break;
        }

    }

    function logout() {

        unsetSessionVariable('currentUser');

        header('Location: ../../../index.php');
        exit;

    }

    function getCustomerDetails() {

        $userService = new UserService;

        $currentUser = getSessionCurrentUser();

        $customerDetails = $userService->getCustomerProfileData($currentUser->getCustomerID());

        echo json_encode($customerDetails);

    }

    function getOrders() {

        $orderService = new OrderService;

        echo json_encode($orderService->getAllCustomerOrders());

    }

?>