<?php
session_start();
if(isset($_SESSION['log_email'])){
	$email=$_SESSION['log_email'];
}
else{
	header("Location: register_email.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to DSquare!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
	<style type="text/css">
		.error_msg{
			text-align: center;
			color: red;
		}
		#second{
			display: none;
		}
	</style>
</head>
<body>
	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1>DSquare!</h1>
				Login below!
			</div>
			<br>
			<div id="first">

				<form method="POST">
					<h3 class="error_msg">OTP expired. Pls. try again.</h3>
					<!-- <input type="text" id="otp" name="log_otp" placeholder="Enter OTP" required>
					<br> -->
				</form>
				<div class="button-div">
					<button class="otp_button" name="otp_button" onclick="resend_otp()">Resend OTP</button>
				</div>

			</div>

		</div>

	</div>
	<script type="text/javascript">
		function resend_otp(){
			// var otp=$("#otp").val();
			$.ajax({
				url:"resend_otp.php",
				method:"post",
				success:function(result){
					if(result==="yes"){
						console.log("Done");
						window.location="otp.php";
					}
					else{
						console.log("Not Done");
						window.location="otp.php";
					}
				}
			})
		}
		
	</script>
</body>
</html>