<?php
    session_start();
    include_once('../utils/session.inc.php');

    if(sess_is_logged_in()) {
        header('Location: /views/gallery.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>
        Register
    </title>
</head>
<body>
</body>
</html>

