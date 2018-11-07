<?php 
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php'); 
	if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']){
		if($_SESSION['Expires'] < time()){
			// Log out here.
			exit();
			header("Location: logout.php");
		}
		$_SESSION['Expires'] = time() + 86400; // if logged in, set to 24 hours.
		//header("Location: Dashboard.php");
	}else{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SocialTune | Friends</title>

	<!--// bootstrap //-->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/specialFX.css" rel="stylesheet">

<script type="text/javascript"
   src="socialtune-chat/client/js/jquery-1.11.0.js">
</script>
<script type="text/javascript"
   src="socialtune-chat/client/js/md5.js">
</script>
<script type="text/javascript"
   src="socialtune-chat/client/js/store.js">
</script>
<script type="text/javascript"
   src="socialtune-chat/client/js/cookies.js">
</script>
<script type="text/javascript"
   src="socialtune-chat/client/js/dateformat.js">
</script>
<script type="text/javascript"
   src="socialtune-chat/client/js/im.js">
</script>
<script type="text/javascript">
$(function(){
  if (!cookies.get('sessionid')) {
    cookies.set('sessionid', uid(40));
  }
  var u =
    window.location.href.split('/');
  var p = 8000; // Node.js port
  u = u[0]+'//'+u[2]+':'+p;
  var im = AjaxIM.init({pollServer: u,
    theme: 'themes/default'});
});
</script>
	
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
					<li><a href="dashboard.php">Home</a></li>
					<?php if($pending_notification == 1){
						echo '<li><span class="relative_blink"><span class="notification_blink"><span class="online_blink">New</span></span></span><a href="notifications.php">Notifications</a></li>'; 
						}else{ echo '<li><a href="notifications.php">Notifications</a><li>';	} // HOLY SHIT THIS IS A CLUSTERFUCK OF BAD. ~~ Ashton
					?>					<li><?php echo'<a href="profile.php?id='.$user_id.'">View Profile</a>'; ?></li>
					<li><a href="edit-profile.php">Edit Profile</a></li> 
					<li class="active"><?php echo '<a href="friends.php?id='.$user_id.'">Friends</a>'; ?>
					<li><a href="about.php">About</a></li>
					<li><a href="logout.php">Log out</a></li>

				</ul>
			</div>
		</div>
	</nav>

	<!--// Content //-->
	<div class="container">
		<div class="jumbotron">
			<div class="row">
				<div class="col-md-8">
						<center><h3>Friends List</h3></center>

							<?php 
								$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
								$isPending = 0;
								$friendslist_id = (!empty($_GET['id'])) ? $_GET['id'] : false;
								$friendslist_id = mysqli_real_escape_string($connection, $friendslist_id);
								$query = "SELECT * FROM friends WHERE user_two='$friendslist_id' AND pending='$isPending' OR user_one='$friendslist_id' AND pending='$isPending'"; // Change user_id to profile_id in profile.
								$get_friends = mysqli_query($connection, $query);

								while($row = mysqli_fetch_array($get_friends, MYSQLI_NUM)){
									$friend_A = $row[1];
									$friend_B = $row[2];

									if($friend_A == $friendslist_id){
										// use friend_B.
										$friend_search = "SELECT * FROM users WHERE id='$friend_B'";
										$get_friend_info = mysqli_query($connection, $friend_search);
										while($friend_info = mysqli_fetch_array($get_friend_info)){
											$friend_info_id = $friend_info[0];
											$friend_info_name = $friend_info[3].' '.$friend_info[4];
											$friend_info_img = $friend_info[11];
											$friend_info_online = $friend_info[13];
										}

									}else{ 
										// use friend_A.
										$friend_search = "SELECT * FROM users WHERE id='$friend_A'";
										$get_friend_info = mysqli_query($connection, $friend_search);
										while($friend_info = mysqli_fetch_array($get_friend_info)){
											$friend_info_id = $friend_info[0];
											$friend_info_name = $friend_info[3].' '.$friend_info[4];
											$friend_info_img = $friend_info[11];
											$friend_info_online = $friend_info[13];
										}
									}
									echo '<div class="col-md-6">';
									echo'<table class="table table-bordered"><tr><td><a href="profile.php?id='.$friend_info_id.'"><img style="width:100px; height:100px;" src="user-images/'.$friend_info_img.'">';
										if($friend_info_online == 1){
											echo '<sup><span class="online_blink_bg"><span class="online_blink">Online</span></span></sup></a></td></tr>';
										}else{
											echo'<sup><span class="offline_blink_bg"><span class="offline_blink">Offline</span></span></sup></a></td></tr>';
										}
									echo '<tr><td><a href="profile.php?id='.$friend_info_id.'">'.$friend_info_name.'</a></td></tr></table></div>';
								}
							?>



					<br />
				</div>
				<div class="col-md-4">
					<div class="col-md-10">
						<h2>Find Friends</h2>
						<form method="POST" action="searchfriend.php">
							<div class="form-group">
								<input type="first_name" class="form-control" name="first_name" placeholder="First Name">
								<input type="last_name" class="form-control" name="last_name" placeholder="Last Name">
							</div>
							<center><h2>OR</h2></center>
							<div class="form-group">
								<input type="email" class="form-control" name="email" placeholder="email">
							</div>
							<div class="form-group">
								<button type="submit" style="float:right;" class="btn btn-primary">Search</button>
							</div>
						</form>
					</div>

				</div>
			</div>
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