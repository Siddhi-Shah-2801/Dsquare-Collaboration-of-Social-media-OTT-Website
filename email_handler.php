<?php 
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //email
$em2 = ""; 
$error_array = array(); 
if(isset($_POST['validation_button'])){
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['reg_fname'] = $fname; //Stores first name into session variable

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['reg_lname'] = $lname; //Stores last name into session variable

	//email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	// $em = ucfirst(strtolower($em)); //Uppercase first letter
	$_SESSION['reg_email'] = $em; //Stores email into session variable

	//email 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2); //remove spaces
	// $em2 = ucfirst(strtolower($em2)); //Uppercase first letter
	$_SESSION['reg_email2'] = $em2; //Stores email2 into session variable

	if($em == $em2) {
		//Check if email is in valid format 
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists 
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}


	}
	else {
		array_push($error_array, "Emails don't match<br>");
	}


	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
	}
	if(empty($error_array)){
		$link="http://localhost/socialmedia/register.php?email=$em,fname=$fname,lname=$lname";
		$squery=mysqli_query($con,"Select * from email_verification where link='$link' and status='1'");
		$scount=mysqli_num_rows($squery);
		if($scount>0){
			header('Location:register_email.php');
			exit();
		}
		$html="Hi ".$fname." ".$lname.",<br>
			   We just need to verify your email address before you can access 
			   DSquare.<br>
			   Verify your email address<br>
			   <a href='$link' style='background-color:blue;color:white;'>Email Validation</a><br><br>
			   Thanks! &#8211;<br>
			   The DSquare Team";
			smtp_mailers($em,"Email Verification",$html);
			?>
			<script type="text/javascript">
				swal("Email has been sent");
			</script>
			<?php
			$email_timestamp =  $_SERVER["REQUEST_TIME"];
			$_SESSION['email_timestamp'] = $email_timestamp;
			$iquery=mysqli_query($con,"Insert into email_verification(fname,lname,email,link,status) values('$fname','$lname','$em','$link','0')");
			if($iquery){
				$id=mysqli_insert_id($con);
				// $_SESSION['reg_fname'] = $fname;
				// $_SESSION['reg_lname'] = $lname;
				// $_SESSION['reg_email'] = $em;
				// $_SESSION['reg_email2'] = $em2;
				$_SESSION['id'] = $id;
				$_SESSION['link'] = $link;
				?>
				<script>
				// $(document).ready(function() {
				// 	$("#first").hide();
				// 	$("#second").show();
				// });
				swal("Email has been sent");

				</script>
				<?php
			}
	}
}
function smtp_mailers($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 0;
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
		return false; 
	}else{
		return true;
	}
}
?>