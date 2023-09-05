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
    $userId = $_SESSION['user_id'];
    $eventId = $_GET['eventId'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reason = $_POST['reason'];
        $sql = "INSERT INTO `report`(eventId,userId,reason)
        VALUES($eventId,$userId,'$reason')";
        $result = mysqli_query($conn, $sql);
        mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=0');
        $sql = "DELETE FROM `event` WHERE eventId = $eventId";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            header('location:alert.php?k=report');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- report -->
    <div class="basic-input-form">
        <div class="input-form-title">Report</div>
        <form action="report.php?eventId=<?=$eventId?>" method='post'>
            <label class="input-form-item">
                <textarea name="reason" placeholder="Reason" rows="10"></textarea>
            </label>
            <div class="btn-group">
                <button type="button" class="btn-basic btn-cancel" onclick="window.location.href='index.php';">Cancel</button>
                <button type="submit" class="btn-basic btn-submit" >Submit</button>
            </div>
        </form>
    </div>
</body>
</html>