<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/model/Customer.php';

    session_start();


    function setSessionCurrentUser($user) {

        $_SESSION['currentUser'] = $user;

    }

    function getSessionCurrentUser() {

        if (isset($_SESSION['currentUser'])) {
            return $_SESSION['currentUser'];
        }
        else {
            return false;
        }
    }

    function unsetSessionVariable($key) {

        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    function destroySession() {

        session_unset();
        session_destroy();

    } 

    function deleteAllCookies() {

        foreach ($_COOKIE as $name => $value) {
            setcookie($name, '', time() -3600, '/');
        }    

    }





?>