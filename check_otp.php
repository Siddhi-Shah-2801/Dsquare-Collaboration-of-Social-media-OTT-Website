<?php 
// session_start();
require 'config.php';
if(isset($_SESSION['log_email'])){
	$email=$_SESSION['log_email'];
}
else{
	header("Location: register_email.php");
}
$otp=$_POST['otp'];
$timestamp =  $_SERVER["REQUEST_TIME"];  // record the current time stamp 
if(($timestamp - $_SESSION['time']) > 60)  // 300 refers to 300 seconds
{
	unset($_SESSION['time']);
	$query=mysqli_query($con,"delete from validate_otp where email='$email' and otp='$otp'");
	echo "OTP expired";
	exit();
}
$query=mysqli_query($con,"Select * from validate_otp where email='$email' and otp='$otp' Limit 1");
$count=mysqli_num_rows($query);
if($count>0){
	
		$query=mysqli_query($con,"Delete from validate_otp where email='$email' and otp='$otp'");
		$squery=mysqli_query($con,"Select * from users where email='$email' Limit 1");
		$row = mysqli_fetch_array($squery);
		$username = $row['username'];
		$_SESSION['username'] = $username;
		echo "yes";
}
else{
	echo "Wrong Otp";
}

?>