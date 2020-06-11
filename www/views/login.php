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
        Login Page
    </title>
</head>
<body>
    <?php 
        if(isset($_GET['status']))
            echo '<p>Status: ' . htmlspecialchars($_GET['status']) . '</p>';
    ?>
    <p>Login</p>
    <form method="POST" action="/endpoint/auth.php">
        <input type="text" name="name" placeholder="Username" />
        <input type="password" name="password" />
        <input type="hidden" name="action" value="login" />
        <input type="submit" value="Login" />
    </form>
    <p>
        Don't have an account yet? Register <a href="/views/register.php">here.</a>
    </p>
</body>
</html>
