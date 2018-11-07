<?php 
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php');

	if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']){
		require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php'); 

		if($_SESSION['Expires'] < time()){
			// Log out here.
			exit();
			header("Location: logout.php");
		}
		$_SESSION['Expires'] = time() + 86400; // if logged in, set to 24 hours.
		//header("Location: Dashboard.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SocialTune | About</title>

	<!--// bootstrap //-->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/specialFX.css" rel="stylesheet">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	html,
	body{
		height: 100%;
	}
	#wrap{
		min-height: 100%;
		height: auto !important;
		height: 100%
		margin: 0 auto -60px;
	}
	#push,
	#footer{
		height: 60px;
	}
	@media(max-width: 767px){
		#footer{
		margin-left: -20px;
		margin-right: -20px;
		padding-left: 20px;
		padding-right: 20px;
		}
	}

	</style>

</head>
<body>
<div id="wrap">
	<!--// Navigation //-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Social.Tune</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php 
					if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']){
						echo '
								<li><a href="dashboard.php">Home</a></li>';
						if($pending_notification == 1){
							echo '<li><span class="relative_blink"><span class="notification_blink"><span class="online_blink">New</span></span></span><a href="notifications.php">Notifications</a></li>'; 
						}else{
							echo '<li><a href="notifications.php">Notifications</a><li>';
						}
													
						echo '	<li><a href="profile.php?id='.$user_id.'">View Profile</a></li>
								<li><a href="edit-profile.php">Edit Profile</a></li> 
								<li><a href="friends.php?id='.$user_id.'">Friends</a></li>
								<li class="active"><a href="about.php">About</a></li>
								<li><a href="logout.php">Log out</a></li>
						';

					}else{
						echo '
							<li><a href="index.php">Login</a></li>
							<li><a href="signup.php">Signup</a></li>
							<li class="active"><a href="about.php">About</a></li>
						';
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<!--// Content //-->
	<div class="container">
		<div class="jumbotron">
			<h2>Social.Tune - What is it?</h2>
			<p> A social networking site:
				<ul>
					<li>Music-centric</li>
					<li>Point System && titles</li>
					<li>NO targetted Ads. -- Just regular, not-as-creepy ads</li>
					<li>User Profiles (Remember mysp**e?)</li>
					<li>Government involvement? Hell no, fuck them. (Of course...As we're in the US, we are kind of required by law if they have a warrent...</li>
					<li>WTF is a browser game? Farmville? B.S. money scheme. Screw that.</li>
					<li>Every band keeps their rights to their own music. We don't own any part of it.</li>
					<li>User Verification. You know who you're talking to. (Parents? :D :D :D)</li>
						<ul>
						<li>Methods: Phone / Letter / Social Confirmations</li>
						<li>Verified Users: MOAR FEATURES</li>
						<li>UNVERIFIED: Can't search, can't downvote, can't contact under 17 year olds, can't customize their page. </li>
						</ul>
					<li>What are you waiting for? Be a hipster (Not even launched yet...Sign up)</li>
				</ul>
			</p>
		</div>
		<div id="push"></div>
	</div>
</div> <!--## ending wrap ##-->

	<!--// Footer //-->
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<p style="font-size: 12px;">Social.Tune &copy; 2015</p>
				</div>
				<div class="col-md-8">
				<p class="text-right" style="font-size: 12px;">
					| <a href="">English</a> | <a href="">汉语</a> | <a href="">日本語</a> |
					<a href="">français</a> |<br />	| <a href="">Social-Tune</a> |
					<a href="">About Us</a> |<a href="">Contact Us</a> | <a href="">Careers</a> |
					<a href="">Privacy</a> | <a href="">License</a> | <a href="">Help</a> |
				</p>
				</div>
			</div>
		</div>
	</div>

</div>
</body>
</html>