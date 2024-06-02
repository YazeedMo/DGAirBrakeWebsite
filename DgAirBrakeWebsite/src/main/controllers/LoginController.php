<?php

    require_once __DIR__ . '/../../main/services/LoginService.php';
    require_once __DIR__ . '/../../main/model/User.php';

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'attemptLogin':
                attemptLogin();
        }

    }

    function attemptLogin() {

        $loginService = new LoginService;

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $loginService->validateUsername($username);

        if ($user === null) {
            echo json_encode(['message' => 'Invalid']);
        }
        else {
            if (!$loginService->verifyPassword($user, $password)) {
                echo json_encode(['message' => 'Invalid']);
            }
            else {
                $_SESSION['current_user'] = $user;
                if ($user->getRole() === "Admin") {
                    header('Location: AdminPanelController.php');
                    exit();
                }
                elseif ($user->getRole() === "Customer") {
                    echo json_encode($user);
                }
            }
        }

    }

?>