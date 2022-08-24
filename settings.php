<?php 
include("header.php");
include("paypalConfig.php");
include("BillingDetails.php");
include("settings_handler.php");

$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage = "";

?>

<div class="main_column column">

	<h4>Account Settings</h4>
	<?php
	//echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">Upload new profile picture</a> <br><br><br>

	Modify the values and click 'Update Details'

	<?php
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	?>

	<form action="settings.php" method="POST">
		First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>
		Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
		Email: <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input"><br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
	</form>

	<h4>Change Password</h4>
	<form action="settings.php" method="POST">
		Old Password: <input type="password" name="old_password" id="settings_input"><br>
		New Password: <input type="password" name="new_password_1" id="settings_input"><br>
		New Password Again: <input type="password" name="new_password_2" id="settings_input"><br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
	</form>


	<div class="formSection">
		<h3 id="sub">Subscription</h3>
		<div class="message">
			<?php echo $subscriptionMessage; ?>
		</div>

		<?php
		$user = new User($con, $userLoggedIn);
		if($user->getIsSubscribed()){
			echo"<h3>You are subscribed ! Go to PayPal to cancel </h3>";
		}
		else {
			echo "<a href='billing.php'>Subscribe to D Square</a>";
		
		}
		?>
	</div>
	<hr>
	<h4>Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>


</div>