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
    <form method="POST" action="/index.php?controller=auth&action=logout">
        <input type="submit" value="Logout" />
    </form>
    <form method="POST" enctype="multipart/form-data" action="/index.php?controller=image&action=upload">
        <input type="text" name="title" />
        <textarea name="descr"></textarea>
        <input type="file" name="image_file" />
        <input type="submit" value="Upload" />
    </form>
</body>
</html>
