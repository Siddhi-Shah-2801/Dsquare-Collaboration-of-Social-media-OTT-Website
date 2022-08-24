<?php
include("config.php");
include("User.php");
include("Message.php");

$limit = 7; //Number of messages to load

$message = new Message($con, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST, $limit);

?>