<?php
require_once("Nconfig.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query = $conn->prepare("SELECT progress FROM videoProgress 
                            WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

    echo $query->fetchColumn();
}
else {
    echo "No videoId or username passed into file";
}
?>