<?php 
require 'config.php';
include('smtp/PHPMailerAutoload.php');
$email='';
$otp='';
	if(isset($_SESSION['log_email'])){
		$email=$_SESSION['log_email'];
		$otp=rand(11111,99999);
	}
	else{
		header("Location: register_email.php");
	}
	$query=mysqli_query($con,"Insert into validate_otp (email,otp) values ('$email','$otp')");
	$html="<p>Your OTP Verification Code is <strong>".$otp."</strong>.<br/>It is your private code don't share it.The otp is valid For 3 minutes</p>";
	$timestamp =  $_SERVER["REQUEST_TIME"];  // generate the timestamp when otp is forwarded to user email/mobile.
    $_SESSION['time'] = $timestamp;
	if(smtp_mailer($email,"Verification Code",$html)){
    	echo "yes";
    	exit();
	}
	// else{
	// 	echo "no";
	// }
	// header("Location: otp.php");
	function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "dsquare1528@gmail.com";
	$mail->Password = "Dsquare1504$";
	$mail->SetFrom("SMTP_EMAIL_ID");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		?>
		<script>
			alert("Error Sending mail");
		</script>
		<?php 
	}else{
		?>
		<script>
			alert("Sent Successfully");
			location.replace="otp.php";
		</script>
		<?php
	}
}
?>
