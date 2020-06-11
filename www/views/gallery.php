<?php
    session_start();
    include_once('../utils/session.inc.php');

    if(!sess_is_logged_in()) {
        header('Location: /views/login.php');
        die();
    }
?>
