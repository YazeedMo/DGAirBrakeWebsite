<?php

    $password = "password";

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    echo "Hashed Password: " . $hashed_password;

?>