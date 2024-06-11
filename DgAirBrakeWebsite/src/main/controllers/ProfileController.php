<?php

    require_once __DIR__ . '/../../main/util/Session.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

        $action = $_GET['action'];

        switch ($action) {
            case 'logout':
                logout();
        }

    }

    function logout() {

        unsetSessionVariable('currentUser');

        header('Location: ../../../index.php');
        exit;

    }

?>