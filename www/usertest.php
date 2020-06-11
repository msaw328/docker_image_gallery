<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');

    $pw = 'halkoa';
    $pwhash = password_hash($pw, PASSWORD_DEFAULT);
    $id = User::insert('aasfsdfaaDGdgsgaaaaa', $pwhash, 'aaiaaaeaag@macieg.com');

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
