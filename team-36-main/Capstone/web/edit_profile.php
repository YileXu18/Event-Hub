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
$sql = "SELECT firstName,lastName,`address`,DOB,Bio,Preference FROM users WHERE `userId` = ".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$profile = mysqli_fetch_assoc($result);

// http post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $DOB = $_POST['DOB'];
    $Bio = $_POST['Bio'];
	$preference = $_POST['preference'];
    $sql = "UPDATE users SET firstName='$firstname',lastName='$lastname',`address`= '$address',DOB='$DOB',Bio='$Bio',Preference='$preference' WHERE `userId` = ".$_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location:view_profile.php');
    }
}

mysqli_close($conn);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- edit profile -->
    <div class="basic-input-form edit-profile-form">
        <div class="input-form-title">Edit Profile</div>
        <form action="edit_profile.php" method="post">
            <label class="input-form-item">
                <input type="text" name="firstname" value="<?=$profile['firstName'] ?? ''?>" required maxlength="64" placeholder="First name" />
                <input type="text" name="lastname" value="<?=$profile['lastName'] ?? ''?>" required maxlength="128" placeholder="Last name" />
            </label>
            <label class="input-form-item">
                <input type="text" name="address" placeholder="Address" value="<?=$profile['address'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="date" name="DOB" placeholder="DOB(yyyy/mm/dd)"  value="<?=$profile['DOB'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="text" name="Bio" maxlength="256" placeholder="Bio" value="<?=$profile['Bio'] ?? ''?>"/>
            </label>
            <label class="input-form-item">
                <input type="text" name="preference" maxlength="512" placeholder="Preference" value="<?=$profile['Preference'] ?? ''?>"/>
            </label>
            <div class="btn-group">
                <button type="button" class="btn-basic btn-cancel" onclick="window.location.href='view_profile.php';">Cancel Edit</button>
                <button type="submit" class="btn-basic btn-submit" >Save Profile</button>
            </div>
        </form>
    </div>
</body>
</html>
