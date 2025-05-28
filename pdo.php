<?php
$servername = "192.168.111.254";
$username = "root";
$password = "boom123";

try {
  $conn = new PDO("mysql:host=$servername;dbname=orpdh", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>