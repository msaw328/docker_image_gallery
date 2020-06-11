<?php
    $db_host = 'db';
    $db_port = '5432';
    $db_user = 'admin';
    $db_pass = 'admin';
    $db_name = 'gallery';

    try {
        $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;user=$db_user;password=$db_pass";
        $dbh = new PDO($dsn);

        $query = 'SELECT * FROM users';
        $stmt = $dbh->prepare($query);

        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['id'] . ' | ' . $row['name'] . '<br />';
        }

    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
?>
