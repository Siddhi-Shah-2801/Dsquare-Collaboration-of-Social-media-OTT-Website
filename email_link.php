<?php
require("config.php");
// $email=$_GET['email'];
// $fname=$_GET['fname'];
// $lname=$_GET['lname'];
$error_array=array();
$verified_time=$_SERVER['REQUEST_TIME'];

// $fname=$_SESSION['reg_fname'];
// $lname=$_SESSION['reg_lname'];
// $email=$_SESSION['reg_email'];
if(isset($_SESSION['reg_fname']) && isset($_SESSION['reg_lname']) &&
isset($_SESSION['reg_email']) && isset($_SESSION['reg_email2'])){
	if(($verified_time - $_SESSION['email_timestamp'])>120){
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
				// alert("Something Went wrong");
				window.location="register.php";
			</script>
			<?php
			// array_push($error_array, "<span style='color: #14C800;'>Email has been Verified!</span><br>");
			// header('Location:register.php');
		}
	}
}else{
	?>
	<script type="text/javascript">
		alert("Something Went wrong");
		window.location="register_email.php";
	</script>
	<?php
}


?>