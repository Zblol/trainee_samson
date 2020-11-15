<?php


$user = "root";
$pass= "";
$dsn = "mysql:host=127.0.0.1;dbname=test_samson";
$option = [PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION];

try{

$pdo = new PDO($dsn,$user,$pass, $option);
}catch (PDOException $e) {

    echo "Не удалось подключиться к базе данных";
}

