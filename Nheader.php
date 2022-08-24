<?php
require 'config.php';
include("User.php");
include("Post.php");
include("Message.php");
include("Notification.php");
require 'Nconfig.php';
include("PreviewProvider.php");
include("Entity.php");
include("CategoryContainers.php");
include("EntityProvider.php");
include("ErrorMessage.php");
include("SeasonProvider.php");
include("Video.php");
include("Season.php");
include("VideoProvider.php");


if(!isset($_SESSION["username"])) {
    header("Location: register_email.php");
}

$userLoggedIn = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to D Square !</title>

    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="assets/js/socialmedia.js"></script>
    <script src="assets/js/jquery.jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>
    <script src="assets/js/script.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.jcrop.css" type="text/css" />
    
</head>
<body>

    <div class="top_bar"> 

        <div class="logo">
            <a href="index.php">D Square !</a>
        </div>


        <div class="search">

            <form action="search.php" method="GET" name="search_form">
                <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

                <div class="button_holder">
                    <img src="assets/images/icons/magnifying_glass.png">
                </div>

            </form>

            <div class="search_results">
            </div>

            <div class="search_results_footer_empty">
            </div>



        </div>

        <nav>
            <?php
                //Unread messages 
                $messages = new Message($con, $userLoggedIn);
                $num_messages = $messages->getUnreadNumber();

                //Unread notifications 
                $notifications = new Notification($con, $userLoggedIn);
                $num_notifications = $notifications->getUnreadNumber();

                //Unread notifications 
                $user_obj = new User($con, $userLoggedIn);
                $num_requests = $user_obj->getNumberOfFriendRequests();

                
            ?>


            <a href="<?php echo $userLoggedIn;?>">
                <?php echo $userLoggedIn;?>
            </a>
            <a href="index.php">
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
                <i class="fa fa-envelope fa-lg"></i>
                <?php
                if($num_messages > 0)
                 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
                ?>
            </a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
                <i class="fa fa-bell fa-lg"></i>
                <?php
                if($num_notifications > 0)
                 echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
                ?>
            </a>
            <a href="request.php">
                <i class="fa fa-users fa-lg"></i>
                <?php
                if($num_requests > 0)
                 echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
                ?>
            </a>
            <a href="Nindex.php">
                <i class="fa fa-youtube-play fa-lg"></i>
            </a>
            <a href="settings.php">
                <i class="fa fa-cog fa-lg"></i>
            </a>
            <a href="logout.php">
                <i class="fa fa-sign-out fa-lg"></i>
            </a>

        </nav>

        <div class="dropdown_data_window" style="height:0px; border:none;"></div>
        <input type="hidden" id="dropdown_data_type" value="">


    </div>


    <script>
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';

    $(document).ready(function() {

        $('.dropdown_data_window').scroll(function() {
            var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
            var scroll_top = $('.dropdown_data_window').scrollTop();
            var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
            var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

            if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

                var pageName; //Holds name of page to send ajax request to
                var type = $('#dropdown_data_type').val();


                if(type == 'notification')
                    pageName = "ajax_load_notifications.php";
                else if(type == 'message')
                    pageName = "ajax_load_messages.php"


                var ajaxReq = $.ajax({
                    url: "" + pageName,
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                    cache:false,

                    success: function(response) {
                        $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
                        $('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 


                        $('.dropdown_data_window').append(response);
                    }
                });

            } //End if 

            return false;

        }); //End (window).scroll(function())


    });

    


    </script>

    <div class='wrappers'>


<?php
if(!isset($hideNav)) {
    include_once("navBar.php");
}
?>

