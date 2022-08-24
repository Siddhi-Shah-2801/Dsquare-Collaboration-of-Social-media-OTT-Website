<?php
ob_start(); //Turns on the output buffering
session_start();
$timezone = date_default_timezone_set("Asia/Calcutta");
/*try {
    $conn = new PDO("mysql:dbname=social;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}*/

$con = mysqli_connect("localhost","root","","social"); //connection variable
if(mysqli_connect_errno())
{
	echo "Failed to Connect: " . mysqli_connect_errno();
} 
?>