<?php
    session_start();
    if (isset($_SESSION['usuario']) && isset($_SESSION['senha'])) {
        echo "Até mais ". $_SESSION['usuario'];
        session_destroy();
    }
?>

<head>
    <meta http-equiv="refresh" content="2; url = login.php">
</head>