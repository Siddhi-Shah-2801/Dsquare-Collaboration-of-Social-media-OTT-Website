<?php
$hideNav = true;

require_once("Nheader.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}
$user = new User($con, $userLoggedIn);
if(!$user->getIsSubscribed()){
    ErrorMessage::show("You must be subscribed to see this. <a href='settings.php'>Click here to subscribe</a>");
    
} 

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($conn, $video);
?>
<div class="watchContainer">

    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fa fa-arrow-left fa-lg"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>


    <div class="videoControls upNext" style="display:none;">

        <button onclick="restartVideo();"><i class="fa fa-redo fa-lg"></i></button>

        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>

            <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>)">
                <i class="fa fa-play fa-lg"></i>Play
            </button>
        </div>
    
    </div>

    <video controls autoplay onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>
<script>
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>