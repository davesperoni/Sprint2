<?php

$server = 'localhost';
$username = 'root';
$password = 'secret';
$database = 'wildlifeDB';

try{
    /*PDO is the new standard for SQL
    the most secure way for doing db transactions in php*/
    $connPDO = new PDO("mysql:host=$server;dbname=$database;", $username, $password);

} catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>