<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f21_team36", "my+sql=i494f21_team36", "i494f21_team36");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
// http post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];
    $event_type = $_POST['event_type'];
    $event_description = $_POST['event_description'];
    if ($event_type == 'alcohol involved') {
        // user age < 21
        $query = "SELECT `DOB` FROM `users` WHERE userId = ".$_SESSION['user_id']." LIMIT 1";
            $result = mysqli_query($conn,$query);
            $user = mysqli_fetch_assoc($result);
            $age = (time()-strtotime($user['DOB']))/(60*60*24*365);
            if ($age < 21) {
                header('location:alert.php?k=u21_create');
                die();
            }
        }
    $sql = "INSERT INTO `event`(userId,eventName,eventLocation,eventDate,eventTime,eventDescription,eventType)
    VALUES($userId,'$event_name','$event_location','$event_date','$event_time','$event_description','$event_type')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location:alert.php?k=create');
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- create event -->
    <div class="basic-input-form create-event-form">
        <div class="input-form-title">Create Event</div>
        <form action="create_event.php" method="post">
            <label class="input-form-item">
                <input type="text" name="event_name" required maxlength="256" placeholder="Event name" />
            </label>
            <label class="input-form-item">
                <input type="date" name="event_date" required placeholder="Event date" />
                <input type="time" name="event_time" required placeholder="Event time" />
            </label>
            <label class="input-form-item">
                <input type="text" name="event_location" required placeholder="Event Location" />
            </label>
            <label class="input-form-item">
                <select name="event_type">
                    <option value="">-select Event Type-</option>
                    <option value="sports" >sports</option>
                    <option value="music" >music</option>
                    <option value="study" >study</option>
                    <option value="party" >party</option>
                    <option value="chilling" >chilling</option>
		    <option value="gaming" >gaming</option>
		    <option value="food & beverage" >food & beverage</option>
		    <option value="coffee" >coffee</option>
		    <option value="reading fair" >reading fair</option>
		    <option value="sports watching" >sports watching</option>
                    <option value="outdoor activity" >outdoor activity</option>
		    <option value="alcohol involved" >alcohol involved</option>
		    <option value="language exchange" >language exchange</option>
		    <option value="pet fair" >pet fair</option>
                    <option value="others" >others</option>
                </select>
            </label>
            <label class="input-form-item">
                <textarea name="event_description" required placeholder="Event description" rows="3"></textarea>
            </label>
            <div class="btn-group">
                <button type="button" class="btn-basic btn-cancel" onclick="window.location.href='index.php';">Cancel Create</button>
                <button type="submit" class="btn-basic btn-submit">Post Event</button>
            </div>
        </form>
    </div>
</body>
</html>
