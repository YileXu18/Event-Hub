<?php
session_start();
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f21_team36", "my+sql=i494f21_team36", "i494f21_team36");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

// Receive http post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailAddress = $_POST['emailAddress'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
    $sql = "SELECT userId FROM users WHERE `emailAddress` = '$emailAddress'";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($res);

    if (!$result) {
        $sql = "INSERT INTO users(firstName,lastName,emailAddress)VALUES('$firstname','$lastname','$emailAddress')";
        $res = mysqli_query($conn, $sql);
        $code = 0;
        $_SESSION['user_id'] = mysqli_insert_id($conn);
    } else {
        $code = 1;
        $_SESSION['user_id'] = $result['userId'];
    }
    
    echo json_encode([
        'code' => $code
    ]);die;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Login - Event</title>
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
    <!-- google platform -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
    <!-- navigation -->
    <div class="navigation-bar">
        <div class="logo">
            <img src="img/logo.svg" alt="logo" />
            <span>EVENT</span>
        </div>
        <div class="userinfo">
            <a href="index.html">Home</a>
        </div>
    </div>
    <!-- login -->
    <div class="basic-input-form">
        <div class="input-form-title">Login</div>
        <form action="">
            <div class="btn-group">
                <div class="g-signin2" data-onsuccess="onSignIn"></div>
			    <div  id="content"></div>
            </div>
        </form>
    </div>

    <script>
        function transfer(obj) {
            var str = "";
            for(var prop in obj){
                str += prop + "=" + obj[prop] + "&"
            }
            return str;
        }
		function onSignIn(googleUser) {
				
			var profile = googleUser.getBasicProfile()
			console.log('User is ' + JSON.stringify(googleUser.getBasicProfile()))
				
			var element = document.querySelector('#content')
			element.innerText = profile.getName();
				
			var image = document.createElement('img')
			image.setAttribute('src', profile.getImageUrl())
			element.append(image)
            console.log('Email: ' + profile.getEmail());
			var email = profile.getEmail();
			var firstName = profile.getGivenName();
			var lastName = profile.getFamilyName();
			if (email) {
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                var api_method = 'POST';
                var api_url = 'login.php';
                var request_data = {
                    "firstname":firstName,
                    "lastname":lastName,
                    "emailAddress":email
                };
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {   
                        var return_data = JSON.parse((xmlhttp.responseText).trim());
                        // console.log(return_data.code);return;
                        if (!return_data.code) {
                            window.location.href="edit_profile.php";
                        } else {
                            window.location.href="index.php";
                        }
                        
                    }
                }
                    xmlhttp.open(api_method,api_url,true);
                    var requestData = transfer(request_data);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xmlhttp.send(requestData);

                }
			}	

            function signOut() {
                gapi.auth2.getAuthInstance().signOut().then(function() {
                    console.log('user signed out');
                    window.location.href="logout.php";
                })
            }	
	</script>
</body>
</html>