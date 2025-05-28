<?php
$host     = '192.168.111.254';
$username = 'root';
$password = 'boom123';
$dbname   ='orpdh';

$conn = new mysqli($host, $username, $password, $dbname);
if(!$conn){
    die("Cannot connect to the database.". $conn->error);
}


