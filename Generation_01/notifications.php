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
	<title>SocialTune | <?php  echo 'profile'; ?></title>

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
					<li><?php echo '<a href="friends.php?id='.$user_id.'">Friends</a></li>'; ?>
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
				<div class="col-md-2">
					uhh... dunno.
				</div>
				<div class="col-md-8">
					<table class="table">
						<caption><center><h2>Notifications</h2></center></caption>
						<?php
							$connect = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
							$query = "SELECT * FROM friends WHERE user_two LIKE '$user_id'";
							$requests = mysqli_query($connect, $query);

							$checked = 0;

							while($row = mysqli_fetch_array($requests, MYSQLI_NUM)){
								$request_user_one = $row[1];
								$request_pending = $row[3];

								$get_user_info = "SELECT * FROM users WHERE id='$request_user_one'";
								$getting_it = mysqli_query($connect, $get_user_info);
								while($userinfo = mysqli_fetch_array($getting_it)){
									$userinfo_id = $userinfo[0];
									$userinfo_name = $userinfo[3].' '.$userinfo[4];
									$userinfo_img = $userinfo[11];
								}
								if($request_pending == 1){
									echo '<tr><td><img style="width:125px; height:125px;" src="user-images/'.$userinfo_img.'"></td>
										<td><a href="profile.php?id='.$userinfo_id.'">'.$userinfo_name.'</a></td>
										<td>
										<form method="POST" action="addfriend.php">
											<input type="hidden" name="requester_id" id="requester_id" value="'.$userinfo_id.'">
											<input type="hidden" name="decline" id="decline" value="2">
											<button type="submit" class="btn btn-primary">Add Friend</button>
										</form>
										</td>
										<td>
										<form method="POST" action="addfriend.php">
											<input type="hidden" name="requester_id" id="requester_id" value="'.$userinfo_id.'">										
											<input type="hidden" name="decline" id="decline" value="1">
											<button type="submit" class="btn btn-primary">Decline</button>
										</form>
										</td>
										</tr>';
								}
								if($pending_notification == 0 && $checked == 0){
									echo '<td>No friend requests pending</td>';
									$checked = 1;
								}
							}

						?>
					</table>
				</div>
			</div>


		</div>
	</div>

		<div id="push"></div>
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