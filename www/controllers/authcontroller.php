<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');

    class AuthController {
        static function login($req, $files) {
            if(!isset($req['name']) || !isset($req['password'])) {
                header('Location: /index.php');
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
                sess_login($user->id, $user->name, $user->email);
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
            header('Location: /views/login.php');
            die();
        }

        static function register($req, $files) {
            if(!isset($req['name']) || !isset($req['password']) || !isset($req['email'])) {
                header('Location: /index.php');
                die();
            }

            $name = $req['name'];
            $pw = $req['password'];
            $email = $req['email'];

            sess_logout();

            if(User::exists($name, $email)) {
                header('Location: /views/register.php?status="Duplicate name/email"');
                die();
            }

            $pwhash = password_hash($pw, PASSWORD_DEFAULT);

            User::insert($name, $pwhash, $email);
            header('Location: /views/login.php?status="Succesfully registered, log in using your new account');
            die();
        }
    }
?>
