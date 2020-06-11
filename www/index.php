<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');

    if(sess_is_logged_in()) {
        header('Location: /views/gallery.php');
    } else {
        header('Location: /views/login.php');
    }
    
    die();
?>
