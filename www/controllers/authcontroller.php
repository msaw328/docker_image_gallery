<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');

    class AuthController {
        static function login($req, $files) {
            if(!isset($req['name']) || !isset($req['password'])) {
                header('Location: /views/login.php?status="Invalid request');
                die();
            }

            $username = $req['name'];
            $password = $req['password'];

            $user = User::get_by_name($username);
    
            if(is_null($user)) {
                header('Location: /views/login.php?status="User not found"');
                die();
            }
    
            if(is_a($user, 'Exception')) {
                header('Location: /views/login.php?status="DB Error"');
                die();
            }
    
            $db_pwhash = $user->pwhash;
    
            if(password_verify($password, $db_pwhash)) {
                sess_login($user->id, $user->name);
                header('Location: /views/gallery.php');
                die();
            } else {
                sess_logout();
                header('Location: /views/login.php?status="Wrong Password"');
                die();
            }
        }

        static function logout($req, $files) {
            sess_logout();
            header('Location: /views/login.php?status="Succesfully logged out"');
            die();
        }

        static function register($req, $files) {
            if(!isset($req['name']) || !isset($req['password'])) {
                header('Location: /views/register.php?status="Invalid request"');
                die();
            }

            $name = $req['name'];
            $pw = $req['password'];

            if(mb_strlen($name) > DB_MAX_LOGIN_LEN) {
                header('Location: /views/register.php?status="Username too long');
                die();
            }

            if(mb_strlen($pw) < SEC_MIN_PASS_LEN) {
                header('Location: /views/register.php?status="Password too short');
                die();
            } 

            sess_logout();

            if(User::exists($name)) {
                header('Location: /views/register.php?status="User with this name already exists"');
                die();
            }

            $pwhash = password_hash($pw, PASSWORD_DEFAULT);

            User::insert($name, $pwhash);
            header('Location: /views/login.php?status="Succesfully registered, log in using your new account');
            die();
        }
    }
?>
