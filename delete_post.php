<?php 
require 'config.php';
	
	if(isset($_GET['post_id'])){
		$post_id = $_GET['post_id'];
	}
	$get_posts = mysqli_query($con, "SELECT  added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_posts);
	$total_posts = $row['num_posts']; 
	$user_posted = $row['added_by'];

	$pquery = mysqli_query($con, "SELECT * FROM users WHERE username='$user_posted'");
	$row = mysqli_fetch_array($pquery);
	$total_user_posts = $row['num_posts'];

	if(isset($_POST['result'])) {
 		if($_POST['result'] == 'true') {
 			$query = mysqli_query($con, "UPDATE posts SET deleted='yes' WHERE id='$post_id'");
 			$total_posts--;
			$query = mysqli_query($con, "UPDATE users SET num_pots='$total_posts' WHERE id='$post_id'");
			$total_user_posts--;
			$user_posts = mysqli_query($con, "UPDATE users SET num_posts='$total_user_posts' WHERE username='$user_posted'");
			$insert_user = mysqli_query($con, "DELETE FROM posts WHERE username='$userLoggedIn' AND post_id='$post_id'"); 			
 		}
 	}
			
?> 


			
	