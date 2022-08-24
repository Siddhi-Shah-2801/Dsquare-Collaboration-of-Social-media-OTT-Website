<?php  
require 'config.php';
include("User.php");
include("Post.php");


if(isset($_POST['post_body'])) {

	$post = new Post($con, $_POST['user_from']);
	$post->submitPost($_POST['post_body'], $_POST['user_to']);
}
	
?>