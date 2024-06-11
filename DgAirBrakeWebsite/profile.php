<?php

    require_once __DIR__ . '/src/main/model/User.php';
    require_once __DIR__ . '/src/main/model/Customer.php';
    require_once __DIR__ . '/src/main/model/Admin.php';
    require_once __DIR__ . '/src/main/util/Session.php';

    if (!getSessionCurrentUser()) {
        header('Location: index.php');
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

    <button id="logout-btn" onclick="logout()">Logout</button>

    <script src="resources/scripts/profile_scripts/script.js"></script>

</body>
</html>