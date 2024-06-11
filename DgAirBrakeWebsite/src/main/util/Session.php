<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/model/Customer.php';

    session_start();


    // Set a new User for the session
    function setSessionCurrentUser($user) {

        $_SESSION['currentUser'] = $user;

    }

    // Returns the User logged in for the current session
    function getSessionCurrentUser() {

        if (isset($_SESSION['currentUser'])) {
            return $_SESSION['currentUser'];
        }
        else {
            return false;
        }
    }

    // Unsets the given session variable
    function unsetSessionVariable($key) {

        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    // Destroys the current session
    function destroySession() {

        session_unset();
        session_destroy();

    } 

    // Deletes all cookies
    function deleteAllCookies() {

        foreach ($_COOKIE as $name => $value) {
            setcookie($name, '', time() -3600, '/');
        }    

    }

?>


