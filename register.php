<?php
require("config.php");
include('smtp/PHPMailerAutoload.php');
require 'register_handler.php';
require 'login_handler.php';
$error_array=array();
$verified_time=$_SERVER['REQUEST_TIME'];
if(isset($_SESSION['reg_fname'])){
	if(($verified_time - $_SESSION['email_timestamp'])>180){
		if(isset($_SESSION['email_timestamp'])){
			unset($_SESSION['email_timestamp']);
		}
		?>
		<script type="text/javascript">
			// alert("Link Expired");
			window.location="register_email.php";
		</script>
		<?php
		// header("Location:register_email.php");
	}
	else{
		$id=$_SESSION['id'];
		$link=$_SESSION['link'];
		$uquery=mysqli_query($con,"update email_verification set status='1' where id='$id' and link='$link'");
		if($uquery){
			$_SESSION['id']='';
			$_SESSION['link']='';
			?>
			<script type="text/javascript">
				// alert("Done");
				// alert("Something Went wrong");
				window.location="register.php";
				$(document).ready(function() {
					$("#first").show();
					$("#second").hide();
				});
					// swal("Email has been sent");
			</script>
			<?php
			// array_push($error_array, "<span style='color: #14C800;'>Email has been Verified!</span><br>");
			// header('Location:register.php');
		}
	}
}else{
	?>
	<script type="text/javascript">
		// alert("Something Went wrong");
		window.location="register_email.php";
	</script>
	<?php
}
// $email=$_GET['email'];
// $fname=$_GET['fname'];
// $lname=$_GET['lname'];
// require 'config.php';
// $em=$_SESSION['reg_email'];
// $squery=mysqli_query($con,"Select * from email_verification where email='$em' and status='1'");
// $count=mysqli_num_rows($squery);
// if($count>0){
// 	header("Location:register.php");
// }
// else{
// 	header("Location:register_email.php");
// }
?>


<html>
<head>
	<title>Welcome to DSquare!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php 
	if(isset($_POST['register_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});

		</script>

		';
	}


	?>

	<div class="wrapper">

		<div class="login_box">

			<div class="login_header">
				<h1>DSquare!</h1>
				Login or sign up below!
			</div>
			<br>
			<div id="first">

				<form action="register.php" method="POST">
					<input type="email" name="log_email" placeholder="Email Address" value="<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					} 
					?>" required>
					<br>
					<input type="password" name="log_password" placeholder="Password">
					<br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "Email or password was incorrect<br>"; ?>
					<input type="submit" name="login_button" value="Login">
					<br>
					<a href="#" id="signup" class="signup">Need an account? Register here!</a>

				</form>

			</div>

			<div id="second">

				<form action="register.php" method="POST">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
					if(isset($_SESSION['reg_fname'])) {
						echo $_SESSION['reg_fname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>

					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
					if(isset($_SESSION['reg_lname'])) {
						echo $_SESSION['reg_lname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" style='border-color: #14C800' required>
					<br>

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" style='border-color: #14C800' required><br>
					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>";?>
					<span style='color: #14C800;'>Email has been Verified!</span><br>
					<br>
					<input type="password" name="reg_password" placeholder="Password" required>
					<br>
					<input type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password only contain english characters or numbers<br>", $error_array)) echo "Your password  only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>


					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>

		</div>

	</div>
	<script type="text/javascript">
		var email1=$("").val();
		var email1=$("").val();
		$.ajax({
			url:"validate_email.php",
			method:"post",
			data:{},
			success:function(result){

			}
		})
	</script>


</body>
</html>