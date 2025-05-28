<?php
$host = "192.168.111.254";
$username = "root";
$userpassword = "boom123";
$dbname = "orpdh";
  
$conn = mysqli_connect($host ,$username ,$userpassword ,$dbname);
$conn->query("set names utf8");

if (mysqli_connect_errno())
{
	//echo "Database Connect Failed : " . mysqli_connect_error();
}
else
{
	//echo "Database Connected.";

}

//mysqli_close($conn);

?>