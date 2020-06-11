<?php
    function sess_is_logged_in() {
        if(!isset($_SESSION['is_logged_in']))
            $_SESSION['is_logged_in'] = false;

        return $_SESSION['is_logged_in'];
    }

    function sess_logout() {
        $_SESSION['is_logged_in'] = false;
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
    }

    function sess_login($id, $name, $email) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
    }

?>
