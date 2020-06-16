<?php
    // by allocating dbh as a static variable we make sure
    // function returns the same object of db connection
    // every time, so we dont open multiple connections to
    // db for no reason
    function db_get_conn() {
        static $dbh = NULL;

        if(is_null($dbh)) {
            $db_host = 'db';
            $db_port = '5432';
            $db_user = 'admin';
            $db_pass = 'admin';
            $db_name = 'gallery';
            
            try {
                $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;user=$db_user;password=$db_pass";
                $dbh = new PDO($dsn);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage();
                die();
            }
        }

        return $dbh;
    }
?>
