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
$like = $_GET['like'] ?? '';
$userId = $_SESSION['user_id'];
$eventId = $_GET['eventId'] ?? 0;
$query = "SELECT * FROM event WHERE eventId = $eventId";
$result = mysqli_query($conn,$query);
$event = mysqli_fetch_assoc($result);

if ($event['eventType'] == 'alcohol involved') {
     // user age < 21
     $query = "SELECT `DOB` FROM `users` WHERE userId = ".$_SESSION['user_id']." LIMIT 1";
     $result = mysqli_query($conn,$query);
     $user = mysqli_fetch_assoc($result);
     $age = (time()-strtotime($user['DOB']))/(60*60*24*365);
     if ($age < 21) {
         header('location:alert.php?k=u21_show');
         die();
    }
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
// like
$query = "SELECT * FROM `like` WHERE eventId = $eventId AND userId = $userId LIMIT 1";
$result = mysqli_query($conn,$query);
$like_row = mysqli_fetch_assoc($result);
// user address
$query = "SELECT `address` FROM `users` WHERE userId = ".$_SESSION['user_id']." LIMIT 1";
$result = mysqli_query($conn,$query);
$user = mysqli_fetch_assoc($result);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Details - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
	<style type="text/css">
		/* Always set the map height explicitly to define the size of the div
       	 * element that contains the map. 
	     */
		#map {
			width: 100%;
	        height: 500px;
		}

		/* Optional: Makes the sample page fill the window. */
		html,
		body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
</head>
<body>
    <!-- navigation -->
    <?php include('header.php'); ?>
    <!-- report -->
    <a href="report.php?eventId=<?=$eventId?>">
    <div class="fixed-switch report-switch" title="Report">
        <img class="universal-icon" src="img/report.svg" style="margin-left: 3px" alt="report">
    </div>
    </a>
    <!-- event details -->
    <div class="basic-display-form">
        <div class="event-action">
            <a href="event_details.php?like=<?=$eventId?>&eventId=<?=$eventId?>">
                <?php if ($like_row) { ?>
                <img src="img/like_red.svg" alt="like"> Like
                <?php } else { ?>
                <img src="img/like.svg" alt="like"> Like   
                <?php } ?>
            </a>
        </div>
        <?php if ($event['userId'] == $_SESSION['user_id']) {?>
        <div class="event-action">
            <a href="edit_event.php?eventId=<?=$eventId?>">
                <img src="img/edit.svg" alt="edit"> Edit event
            </a>
        </div>
        <?php } ?>
        <form action="">
            <div class="input-form-item">
                <span class="details-form-item-label">Event name: </span>
                <span class="details-form-item-value"><?=$event['eventName']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Event datetime: </span>
                <span class="details-form-item-value"><?=$event['eventDate'].' '.$event['eventTime']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Event Location: </span>
                <span class="details-form-item-value"><?=$event['eventLocation']?></span>
            </div>
			<div class="input-form-item">
                <span class="details-form-item-label">Distance: </span>
                <span class="details-form-item-value" id="response"></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Event type: </span>
                <span class="details-form-item-value"><?=$event['eventType']?></span>
            </div>
            <div class="input-form-item">
                <span class="details-form-item-label">Event description: </span>
                <span class="details-form-item-value"><?=$event['eventDescription']?></span>
            </div>
        </form>
		<div id="showMap">
			<!--DOM-->
			<div id="map"></div>  
		</div>
    </div>
	<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-H1xh16bKAjeGqqxWPnhKdowJRkGCYPM&callback=initMap&v=weekly"
      async
    ></script>
	<script>
		var lat,lng,lat1,lng1;
		var address = "<?=$event['eventLocation']?>";
		let map;
		function initMap() {
			$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyB-H1xh16bKAjeGqqxWPnhKdowJRkGCYPM', function(data){
				lat = data.results[0].geometry.location.lat;
				lng = data.results[0].geometry.location.lng;
				map = new google.maps.Map(document.getElementById("map"), {
					center: { lat: lat, lng: lng },
					zoom: 16,
				});
				new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map,
                    title: address,
                });
			});	
			// Distance
			const service = new google.maps.DistanceMatrixService();
  			// build request
			const origin = "<?=$user['address']?>";
			const destination = address;
			const request = {
				origins: [origin],
				destinations: [destination],
				travelMode: google.maps.TravelMode.DRIVING,
				unitSystem: google.maps.UnitSystem.IMPERIAL,
				avoidHighways: false,
				avoidTolls: false,
			};
			// get distance matrix response
			service.getDistanceMatrix(request).then((response) => {
				// put response
				var str = JSON.stringify(
					response.rows[0].elements[0].distance.text,
					null,
					2
				);
				document.getElementById("response").innerText = str.replace(/(\")/g, "");
			});
		}
	</script>
</body>
</html>
