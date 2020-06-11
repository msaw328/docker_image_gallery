<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');

    if(!sess_is_logged_in()) {
        header('Location: /views/login.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>
        Login Page
    </title>
</head>
<body>
    <?php
        var_dump($_SESSION);
    ?>
    <form method="POST" action="/endpoint/auth.php">
        <input type="hidden" name="action" value="logout" />
        <input type="submit" value="Logout" />
    </form>
</body>
</html>
