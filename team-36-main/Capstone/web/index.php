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
$event_name = $_GET['event_name'] ?? '';
$event_type = $_GET['event_type'] ?? '';
$event_location = $_GET['event_location'] ?? '';
$event_date = $_GET['event_date'] ?? '';
$like = $_GET['like'] ?? '';
$where = "1=1 ";
if ($event_name) {
    $where .= "AND eventName LIKE '%".$event_name."%'";
}
if ($event_type) {
    $where .= "AND eventType LIKE '%".$event_type."%'";
}
if ($event_location) {
    $where .= "AND eventLocation LIKE '%".$event_location."%'";
}
if ($event_date) {
    $where .= "AND eventDate = '".$event_date."'";
}
if ($like) {
    $query = "SELECT * FROM `like` WHERE eventId=$like AND userId = $userId LIMIT 1";
    $result = mysqli_query($conn,$query);
    $like_row = mysqli_fetch_row($result);
    if ($like_row) {
        $query = "DELETE FROM `like` WHERE eventId=$like AND userId = $userId";
        $result = mysqli_query($conn,$query);
    } else {
        $sql = "INSERT INTO `like`(eventId,userId)VALUES($like,$userId)";
        $res = mysqli_query($conn, $sql);
    }
}

// Execute queries
$query = "SELECT * FROM `event` LEFT JOIN (SELECT eventId as likeId FROM `like` WHERE userId = $userId) `like` on event.eventId=like.likeId WHERE $where";
$result = mysqli_query($conn,$query);
$events = mysqli_fetch_all($result, MYSQLI_ASSOC);

// user address
$query = "SELECT `address` FROM `users` WHERE userId = ".$_SESSION['user_id']." LIMIT 1";
$result = mysqli_query($conn,$query);
$user = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <?php include('header.php'); ?>
    <!-- search event -->
    <div class="search-bar">
        <form action="index.php" method="GET">
            <div class="input-form-item">
                <label>
                    <input type="text" value="<?=$_GET['event_name'] ?? ''?>" name="event_name"  maxlength="256" placeholder="Event Name" />
                </label>
                <label>
                    <!-- <input type="text" value="<?=$_GET['event_type'] ?? ''?>" name="event_type"  maxlength="8" placeholder="Event Type" /> -->
                    <select name="event_type">
                        <option value="">-Event Type-</option>
                        <option value="sports" <?php if($event_type=='sports') echo 'selected'; ?>>sports</option>
                        <option value="music" <?php if($event_type=='music') echo 'selected'; ?>>music</option>
                        <option value="study" <?php if($event_type=='study') echo 'selected'; ?>>study</option>
                        <option value="party" <?php if($event_type=='party') echo 'selected'; ?>>party</option>
                        <option value="chilling" <?php if($event_type=='chilling') echo 'selected'; ?>>chilling</option>
                        <option value="gaming" <?php if($event_type=='gaming') echo 'selected'; ?>>gaming</option>
			<option value="food & beverage" <?php if($event_type=='food & beverage') echo 'selected'; ?>>food & beverage</option>
			<option value="coffee" <?php if($event_type=='coffee') echo 'selected'; ?>>coffee</option>
			<option value="reading fair" <?php if($event_type=='reading fair') echo 'selected'; ?>>reading fair</option>
            		<option value="sports watching" <?php if($event_type=='sports watching') echo 'selected'; ?>>sports watching</option>
            		<option value="outdoor activity" <?php if($event_type=='outdoor activity') echo 'selected'; ?>>outdoor activity</option>
			<option value="alcohol involved" <?php if($event_type=='alcohol involved') echo 'selected'; ?>>alcohol involved</option>
			<option value="language exchange" <?php if($event_type=='language exchange') echo 'selected'; ?>>langeuage exchange</option>
			<option value="pet fair" <?php if($event_type=='pet fair') echo 'selected'; ?>>pet fair</option>
                        <option value="others" <?php if($event_type=='others') echo 'selected'; ?>>others</option>
                    </select>
                </label>
                <label>
                    <input type="text" value="<?=$_GET['event_location'] ?? ''?>" name="event_location"  placeholder="Event Location" />
                </label>
                <label>
                    <input type="date" value="<?=$_GET['event_date'] ?? ''?>" name="event_date"  placeholder="Event Date" />
                </label>
                <button type="submit" class="btn-basic btn-submit form-inner-btn">Search</button>
                <!-- <button type="reset" class="btn-basic btn-cancel form-inner-btn">Reset</button> -->
                <button type="button" class="btn-basic form-inner-btn" onclick="window.location.href='create_event.php';">Create</button>
            </div>
        </form>
    </div>
    <!-- search result -->
    <div class="event-box">
        <?php foreach($events as $key => $event) {?>
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
		 <?php if ($event['eventType'] != 'alcohol involved') {?>
                <a href="event_details.php?eventId=<?=$event['eventId']?>">
                    <img src="img/location.svg" width="14" height="14" alt="location">
                    <span class="event-footer-location"><?=$event['eventLocation']?></span>
                </a>
                &nbsp;&nbsp;&nbsp;
                <span class="event-footer-distance" id="<?=$key?>"></span>
                <span style="float: right">
                <?php if ($event['likeId']) { ?>
                    <a href="index.php?like=<?=$event['eventId']?>"><img src="img/like_red.svg" width="16" height="16" style="margin: 10px;cursor: pointer;" alt="like"></a>
                <?php } else { ?>
                    <a href="index.php?like=<?=$event['eventId']?>"><img src="img/like.svg" width="16" height="16" style="margin: 10px;cursor: pointer;" alt="like"></a>
                <?php } ?>
                </span>
		<?php } else {?>
		<a href="event_details.php?eventId=<?=$event['eventId']?>">
                    <img src="img/location.svg" width="14" height="14" alt="location">
                    <span class="event-footer-location">click in to see</span>
		</a>
                <?php } ?>
            </div>
        </div>
        <?php }?>
        
    </div>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-H1xh16bKAjeGqqxWPnhKdowJRkGCYPM&callback=initMap&v=weekly"
      async
    ></script>
    <script>
		function initMap() {
			// Distance
			const service = new google.maps.DistanceMatrixService();
  			// build request
			const origin = "<?=$user['address']?>";
            var destinations = [];
            <?php foreach($events as $key => $value) {?>
                destinations[<?=$key?>] = "<?=$value['eventLocation']?>"
            <?php } ?>
            console.log(destinations);
			const request = {
				origins: [origin],
				destinations: destinations,
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.IMPERIAL,
				avoidHighways: false,
				avoidTolls: false,
			};
            console.log(request);
			// get distance matrix response
			service.getDistanceMatrix(request).then((response) => {
                var result = response.rows[0].elements;    
                for(x in result) {
                    console.log(result[x].distance.text);
                    // put response
                    var str = JSON.stringify(
                        result[x].distance.text,
                        null,
                        2
                    );
                    document.getElementById(x).innerHTML = str.replace(/(\")/g, "");
                }
				
			});
		}
	</script>
</body>
</html>
