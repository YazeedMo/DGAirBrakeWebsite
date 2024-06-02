<?php

    require_once __DIR__ . '/../../main/model/Admin.php';

    session_start();

    $user = isset($_SESSION['current_user']) ? $_SESSION['current_user'] : null;

    if ($user !== null) {
        if ($user->getRole() === "Admin") {
            header("Location: ../../../admin_panel.php");
        }
    }
    else {
        echo "Session object not found";
    }

?>