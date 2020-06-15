<?php
    // dimensions of generated thumbnails
    // Thumbnails are not generated on the fly,
    // so changing these settings will have no effect
    // on Thumbs already in the database
    define('APP_THUMB_WIDTH', 200);
    define('APP_THUMB_HEIGHT', 200);

    // Contraints for user input to be checked server side
    // Modifying those variables requires that you also change
    // Table structures in the database! (change gallery.sql
    // and remove db_data/) and provide frontend validation
    define('DB_MAX_LOGIN_LEN', 32);
    define('DB_MAX_CAT_NAME_LEN', 40);
    define('DB_MAX_IMAGE_TITLE_LEN', 50);
    define('DB_MAX_IMAGE_DESCR_LEN', 400);

    // Security
    define('SEC_MIN_PASS_LEN', 2);
?>
