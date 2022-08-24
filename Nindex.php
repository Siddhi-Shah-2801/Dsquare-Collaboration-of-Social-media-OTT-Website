<?php 
include("Nheader.php");

$preview = new PreviewProvider($conn,$userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($conn,$userLoggedIn);
echo $containers->showAllCategories(null); 


?>