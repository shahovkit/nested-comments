<?php

$servername = "mysql";
$username = "test";
$password = "test";
$dbname = 'test';

$GLOBALS['connection'] = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
$GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$GLOBALS['connection']->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function fetchAll($sql) {
    $sth = $GLOBALS['connection']->prepare($sql);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}



