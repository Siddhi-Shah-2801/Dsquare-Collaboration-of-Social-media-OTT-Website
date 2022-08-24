<?php
require_once("Nheader.php");

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createMoviesPreviewVideo();

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showMovieCategories();
?>