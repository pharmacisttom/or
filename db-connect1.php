<?php
$host     = '192.168.111.251';
$username = 'root';
$password = 'boom123';
$dbname   ='orpdh';

$conn = new mysqli($host, $username, $password, $dbname);
$conn->query("set names utf8");
if(!$conn){
    die("Cannot connect to the database.". $conn->error);
}