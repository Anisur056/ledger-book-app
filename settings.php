<?php

    $host='localhost';
    $user='root';
    $pass='';
    $db='test-ledger-book';
    $tbl_prefix='';
    $charset='utf8';
    $web_socket='http://';
    $server='192.168.0.151';
    $dir='business-accounts/';
    $web_address = $web_socket.$server.'/'.$dir;
    $time_zone='Asia/Dhaka';
    date_default_timezone_set('Asia/Dhaka');

    try
    {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset='.$charset,$user,$pass);
    }
    catch (PDOException $e)
    {        
        $server_error = 1;
    }

?>