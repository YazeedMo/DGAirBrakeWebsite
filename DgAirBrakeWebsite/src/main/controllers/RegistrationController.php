<?php

    require_once __DIR__ . '/../../main/services/RegistrationService.php';
    require_once __DIR__ . '/../../main/util/Session.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'checkUsername':
                checkUsername();
                break;
            case 'checkCardNumber':
                checkCardNumber();
                break;
            case 'registerUser':
                registerUser();
                break;
        }

    }

    function checkUsername() {

        if (!isset($_POST['username'])) {
            echo json_encode(['status' => 'error', 'message' => 'Username is missing']);
            return;
        }

        $username = $_POST['username'];

        $registrationService = new RegistrationService;

        if (!$registrationService->validateUsername($username)) {
            $response = ['validUsername' => false];
        }
        else {
            $response = ['validUsername' => true];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);

    }

    function checkCardNumber() {

        if (!isset($_POST['cardNumber'])) {
            echo json_encode(['status' => 'error', 'message' => 'CardNumber is missing']);
            return;
        }

        $cardNumber = $_POST['cardNumber'];

        $registrationService = new RegistrationService;

        if (!$registrationService->validateCardNumber($cardNumber)) {
            $response = ['validCardNumber' => false];
        }
        else {
            $response = ['validCardNumber' => true];
        }

        echo json_encode($response);

    }

    function registerUser() {

        $registrationService = new RegistrationService;

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);

        // Sanitize data with htmlspecialchars()
        $cardNumber = htmlspecialchars($data['cardDetails']['cardNumber']);
        $expirationDate = htmlspecialchars($data['cardDetails']['expirationDate']);
        $cardType = htmlspecialchars($data['cardDetails']['cardType']);

        $addressString = htmlspecialchars($data['addressInfo']['addressString']);
        $areaCode = htmlentities($data['addressInfo']['areaCode']);

        $username = htmlspecialchars($data['personalDetails']['username']);
        $email = htmlspecialchars($data['personalDetails']['email']);

        // Hash password
        $password = $data['personalDetails']['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $currentUser = $registrationService->addCustomer($username,
                                          $hashed_password,
                                          $email,
                                          $addressString,
                                          $areaCode,
                                          $cardNumber,
                                          $expirationDate,
                                          $cardType);

        if ($currentUser === null) {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
        }
        else {
            setSessionCurrentUser($currentUser);
            echo json_encode(['status' => 'success', 'redirectUrl' => 'index.php']);
        }

    }

?>