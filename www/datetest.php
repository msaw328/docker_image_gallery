<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/image.php');

    echo Image::insert(1, 'muj pliczek', 'bardzo fajny pliczek ktory zrobilem', 'png', 'AAAAAAAAAAAAAAAAAAAA');
?>
