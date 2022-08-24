<?php 
include("config.php");
include("User.php");
include("Notification.php");

$limit = 7; //Number of messages to load

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>