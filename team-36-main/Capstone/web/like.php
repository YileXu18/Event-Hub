<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f21_team36", "my+sql=i494f21_team36", "i494f21_team36");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
$userId = $_SESSION['user_id'];


// Execute queries
$query = "SELECT * FROM (SELECT eventId as likeId FROM `like` WHERE userId = $userId) `like` LEFT JOIN `event` ON event.eventId=like.likeId";
$result = mysqli_query($conn,$query);
$like_events = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Like - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- search result -->
    <div class="event-box">
        <?php foreach($like_events as $event) {?>
            <div class="event-item">
            <div class="event-header">
                <a href="event_details.php?eventId=<?=$event['eventId']?>">
                    <span class="event-header-title"><?=$event['eventName']?></span>
                </a>
                <span class="event-header-type"><?=$event['eventType']?></span>
            </div>
            <div class="event-body">
                <pre class="event-body-description"><?=$event['eventDescription']?></pre>
            </div>
            <div class="event-footer">
                <span class="event-footer-datetime"><?=$event['eventDate']?> <?=$event['eventTime']?></span>
                <a href="event_details.php?eventId=<?=$event['eventId']?>">
                    <img src="img/location.svg" width="14" height="14" alt="location">
                    <span class="event-footer-location"><?=$event['eventLocation']?></span>
                </a>
            </div>
        </div>
        <?php }?>
        
    </div>
</body>
</html>