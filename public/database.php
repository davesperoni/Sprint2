<?php

$server = '127.0.0.1';
$username = 'homestead';
$password = 'secret';
$database = 'wildlifeDB';

$conn = mysqli_connect($server,$username,$password,$database);

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>