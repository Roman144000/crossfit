<?php

    // connect to db
    include_once('safemysql.class.php');
    $opts = array(
        'host'    => 'localhost',
        'user'    => 'root',
        'pass'    => 'root',
        'db'      => 'crossfit',
        'charset' => 'utf8mb4',
    );
    $db = new SafeMySQL($opts);