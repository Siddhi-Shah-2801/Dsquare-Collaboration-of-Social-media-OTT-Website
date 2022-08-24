<?php  
// include('smtp/PHPMailerAutoload.php');
$email='';
$otp='';
if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //sanitize email

	$_SESSION['log_email'] = $email; //Store email into session variable 
	$password = md5($_POST['log_password']); //Get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['username'];

		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
		}

		// $_SESSION['username'] = $username;
		$otp=rand(11111,99999);
		$timestamp =  $_SERVER["REQUEST_TIME"];  // generate the timestamp when otp is forwarded to user email/mobile.
        $_SESSION['time'] = $timestamp;
		$query=mysqli_query($con,"Insert into validate_otp (email,otp) values ('$email','$otp')");
		$html="<p>Your OTP Verification Code is <strong>".$otp."</strong>.<br/>It is your private code don't share it.The otp is valid For 3 minutes</p>";
		if(smtp_mailer($email,"Verification Code",$html)){
			$timestamp =  $_SERVER["REQUEST_TIME"];  // generate the timestamp when otp is forwarded to user email/mobile.
        	$_SESSION['time'] = $timestamp;
		}
		header("Location: otp.php");
		exit();
	}
	else {
		array_push($error_array, "Email or password was incorrect<br>");
	}


}
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
		</script>
		<?php
	}
}

?>