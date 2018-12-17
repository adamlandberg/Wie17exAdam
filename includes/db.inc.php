<?php

$dsn = 'mysql:dbname='.$settings['db']['database'].';host='.$settings['db']['host'];


try {
    $dbh = new PDO($dsn, $settings['db']['user'], $settings['db']['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}


 catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}