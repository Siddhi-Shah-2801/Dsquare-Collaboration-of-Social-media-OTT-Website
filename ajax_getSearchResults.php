<?php
require_once("Nconfig.php");
require_once("SearchResultsProvider.php");
require_once("EntityProvider.php");
require_once("Entity.php");
require_once("PreviewProvider.php");

if(isset($_POST["term"]) && isset($_POST["username"])) {
    
    $srp = new SearchResultsProvider($conn, $_POST["username"]);
    echo $srp->getResults($_POST["term"]);

}
else {
    echo "No term or username passed into file";
}
?>