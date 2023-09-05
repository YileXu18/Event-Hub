<!-- navigation -->
<div class="navigation-bar">
    <div class="logo">
        <img src="img/logo.svg" alt="logo" />
        <span>EVENT</span>
    </div>
    <div class="userinfo">
        <a href="index.php" >Home</a>
        <span class="vertical-dividing-line">|</span>
        <a href="like.php">Like</a>
        <span class="vertical-dividing-line">|</span>
        <a href="posted_event.php">Posted event</a>
        <span class="vertical-dividing-line">|</span>
        <a href="edit_profile.php">Edit profile</a>
        <span class="vertical-dividing-line">/</span>
        <a href="view_profile.php">View Profile</a>
        <span class="vertical-dividing-line">|</span>
        <a href="javascript:void(0);" onclick="signOut()">Logout</a>
    </div>
</div>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<script>
    function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    console.log('User signed out.');
    window.location.href="logout.php";
    });
}

function onLoad() {
    gapi.load('auth2', function() {
    gapi.auth2.init();
    });
}
</script>