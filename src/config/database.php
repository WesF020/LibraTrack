<?php

function getConnection(): PDO {
    $host       = getenv('DB_HOST');
    $dbname     = getenv('DB_NAME');
    $user       = getenv('DB_USER');
    $password   = getenv('DB_PASSWORD');

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    )];

    return $pdo;

}