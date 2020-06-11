<?php
    /*session_start();
    include_once('../utils/session.inc.php');

    if(sess_is_logged_in()) {
        header('Location: /views/gallery.php');
    } else {
        header('Location: /views/login.php');
    }
    
    die();*/

    include_once('./models/user.php');

    $pw = 'halkoa';
    $pwhash = password_hash($pw, PASSWORD_DEFAULT);
    $id = User::insert('aasfsdfaaDGdgsgaaa', $pwhash, 'aaiaaaeg@macieg.com');

    if(is_a($id, 'Exception')) {
        print $id->getMessage();
        die();
    }

    print 'INSERT returned id ' . strval($id);

    $user = User::get($id);

    if(is_null($user)) {
        print 'NO SUCH USER!';
        die();
    }

    if(is_a($id, 'Exception')) {
        print $id->getMessage();
        die();
    }

    print 'SELECT returned user<br />r<br />r<br />';
    var_dump($user);

    User::delete($id);

    $user = User::get($id);

    if(is_null($user)) {
        print 'NO SUCH USER!';
        die();
    }

    if(is_a($id, 'Exception')) {
        print $id->getMessage();
        die();
    }

    print 'SELECT returned user<br />r<br />r<br />';
    var_dump($user);

?>
