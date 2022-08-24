<?php
require_once("Nheader.php");

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createTVShowPreviewVideo();

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showTVShowCategories();
?>