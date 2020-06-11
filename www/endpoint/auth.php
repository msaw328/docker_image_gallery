<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/authcontroller.php');

    // endpoint used for authentication
    // POST requests define variable 'action'
    // possible actions: login, logout and register
    // login requires name and password
    // logout does not require anything
    // register requires name, password and email
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /index.php');
        die();
    }

    if(!isset($_POST['action'])) {
        header('Location: /index.php');
        die();
    }

    $action = $_POST['action'];

    if($action === 'login') {
        if(!isset($_POST['name']) || !isset($_POST['password'])) {
            header('Location: /index.php');
            die();
        }

        AuthController::login($_POST['name'], $_POST['password']);
    }

    if($action === 'logout') {
        AuthController::logout();
    }

    if($action === 'register') {
        if(!isset($_POST['name']) || !isset($_POST['password']) || !isset($_POST['email'])) {
            header('Location: /index.php');
            die();
        }
        AuthController::register($_POST['name'], $_POST['password'], $_POST['email']);
    }

    header('Location: /index.php');
?>
