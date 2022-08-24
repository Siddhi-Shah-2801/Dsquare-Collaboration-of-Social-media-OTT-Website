<?php
require_once("Nheader.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No id passed to page");
}

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
?>