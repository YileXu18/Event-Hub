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
$sql = "SELECT emailAddress,firstName,lastName,`address`,DOB,Bio,Preference FROM users WHERE `userId` = ".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$profile = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Profile - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- user profile -->
    <div class="basic-display-form">
        <div class="event-action">
            <a href="edit_profile.php">
                <img src="img/edit.svg" alt="edit"> Edit user profile
            </a>
        </div>
        <form action="">
            <div class="input-form-item">
                <span class="details-form-item-label">Email address: </span>
                <span class="details-form-item-value"><?=$profile['emailAddress']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">First name: </span>
                <span class="details-form-item-value"><?=$profile['firstName']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Last name: </span>
                <span class="details-form-item-value"><?=$profile['lastName']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Address: </span>
                <span class="details-form-item-value"><?=$profile['address']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">DOB: </span>
                <span class="details-form-item-value"><?=$profile['DOB']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Bio: </span>
                <span class="details-form-item-value"><?=$profile['Bio']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Preference: </span>
                <span class="details-form-item-value"><?=$profile['Preference']?></span>
            </div>
        </form>
    </div>
</body>
</html>