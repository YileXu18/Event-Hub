<?php
session_start();
$eventId = $_GET['eventId'];
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f21_team36", "my+sql=i494f21_team36", "i494f21_team36");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
$sql = "SELECT * FROM `event` WHERE `eventId` = ".$eventId;
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

// http post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];
    $event_type = $_POST['event_type'];
    $event_description = $_POST['event_description'];
    $sql = "UPDATE `event` SET eventName='$event_name',eventDate='$event_date',`eventTime`= '$event_time',eventLocation='$event_location',eventType='$event_type',eventDescription='$event_description' WHERE `eventId` = ".$eventId;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location:alert.php?k=edit&eventId='.$eventId);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- edit profile -->
    <div class="basic-input-form edit-profile-form">
        <div class="input-form-title">Edit Event</div>
        <form action="edit_event.php?eventId=<?=$eventId?>" method="post">
            <label class="input-form-item">
                <input type="text" name="event_name" placeholder="Event name" value="<?=$event['eventName'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="date" name="event_date" placeholder="Event date"  value="<?=$event['eventDate'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="time" name="event_time" placeholder="Event time"  value="<?=$event['eventTime'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="text" name="event_location" placeholder="Event location" value="<?=$event['eventLocation'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <select name="event_type">
                        <option value="">-select Event Type-</option>
                        <option value="sports" <?php if($event['eventType']=='sports') echo 'selected'; ?>>sports</option>
                        <option value="music" <?php if($event['eventType']=='music') echo 'selected'; ?>>music</option>
                        <option value="study" <?php if($event['eventType']=='study') echo 'selected'; ?>>study</option>
                        <option value="party" <?php if($event['eventType']=='party') echo 'selected'; ?>>party</option>
                        <option value="chilling" <?php if($event['eventType']=='chilling') echo 'selected'; ?>>chilling</option>
			<option value="gaming" <?php if($event['eventType']=='gaming') echo 'selected'; ?>>gaming</option>
			<option value="food & beverage" <?php if($event['eventType']=='food & beverage') echo 'selected'; ?>>food & beverage</option>
			<option value="coffee" <?php if($event['eventType']=='coffee') echo 'selected'; ?>>coffee</option>
			<option value="reading fair" <?php if($event['eventType']=='reading fair') echo 'selected'; ?>>reading fair</option>
            		<option value="sports watching" <?php if($event['eventType']=='sports watching') echo 'selected'; ?>>sports watching</option>
            		<option value="outdoor activity" <?php if($event['eventType']=='outdoor activity') echo 'selected'; ?>>outdoor activity</option>
			<option value="alcohol involved" <?php if($event['eventType']=='alcohol involved') echo 'selected'; ?>>alcohol involved</option>
			<option value="language exchange" <?php if($event['eventType']=='language exchange') echo 'selected'; ?>>language exchange</option>
			<option value="pet fair" <?php if($event['eventType']=='pet fair') echo 'selected'; ?>>pet fair</option>
                        <option value="others" <?php if($event['eventType']=='others') echo 'selected'; ?>>others</option>
                    </select>
            </label>
            <label class="input-form-item">
                <input type="text" name="event_description" placeholder="Event decription" value="<?=$event['eventDescription'] ?? ''?>"/>
            </label>
            <div class="btn-group">
                <button type="button" class="btn-basic btn-cancel" onclick="window.location.href='event_details.php?eventId=<?=$eventId?>';">Cancel Edit</button>
                <button type="submit" class="btn-basic btn-submit" >Save Event</button>
            </div>
        </form>
    </div>
</body>
</html>
