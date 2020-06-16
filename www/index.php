<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/router.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/authcontroller.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/imagecontroller.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/categorycontroller.php');

    // index.php - routing logic, most calls go here and are routed
    // based on route() calls below as well as given controller/action names

    // routes: request method - controller - action - callback(req, files)
    route('POST', 'auth', 'login', 'AuthController::login');
    route('POST', 'auth', 'register', 'AuthController::register');
    route('POST', 'auth', 'logout', 'AuthController::logout');

    route('POST', 'image', 'upload', 'ImageController::upload');
    route('POST', 'image', 'alter_meta', 'ImageController::alter_meta');
    route('POST', 'image', 'delete', 'ImageController::delete');
    route('GET', 'image', 'fetch_raw', 'ImageController::fetch_raw');
    route('GET', 'image', 'fetch_thumb_raw', 'ImageController::fetch_thumb_raw');
    route('GET', 'image', 'allowed_ids', 'ImageController::allowed_ids');

    route('GET', 'category', 'get_owned', 'CategoryController::get_owned');
    route('POST', 'category', 'create', 'CategoryController::create');
    route('POST', 'category', 'delete', 'CategoryController::delete');

    // default routes
    if(sess_is_logged_in()) {
        header('Location: /views/gallery.php');
    } else {
        header('Location: /views/login.php');
    }
?>
