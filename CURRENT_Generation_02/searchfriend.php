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
	<title>SocialTune | Find Friends</title>

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
				<div class="col-md-12">
						<center><h3>Find your friends</h3></center>
						<table class="table table-bordered">
						<tr>
						<td></td>
						<td>Name</td>
						<td>Country</td>
						<td>State</td>
						<td>Town</td>
						</tr>

							<?php
								// posts: "first_name", "last_name", and "email".
								$query_fname = (!empty($_POST['first_name'])) ? $_POST['first_name'] : false;
								$query_lname = (!empty($_POST['last_name'])) ? $_POST['last_name'] : false;
								$query_email = (!empty($_POST['email'])) ? $_POST['email'] : false;

								if($query_fname && $query_lname || $query_email){
									$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

									if($query_fname && $query_lname){
										$query = "SELECT * FROM users WHERE first_name='$query_fname' AND last_name='$query_lname'";
									}

									if($query_email){
										$query = "SELECT * FROM users WHERE email LIKE'$query_email' LIMIT 0,15";
									}

									$data = mysqli_query($connection, $query);

									if(mysqli_num_rows($data) > 0){
										while($info = mysqli_fetch_array($data, MYSQLI_ASSOC)){
											echo '<tr>';
											echo '<td><a href="profile.php?id='.$info['id'].'"><img style="width: 150px; height: 150px;" src="user-images/'.$info['default_image'].'"></a></td>';
											echo '<td><a href="profile.php?id='.$info['id'].'">'.$info['first_name'].' '.$info['last_name'].'</a></td>';
											echo '<td>'.$info['location_country'].'</td>';
											echo '<td>'.$info['location_state'].'</td>';
											echo '<td>'.$info['location_town'].'</td>';
											echo '</tr>';
										}
									}else{
										echo '<center><p style="color: red;">No records found.</p></center>'; // This sounds fucking robotic. Change this.
									}


								}else{
									echo 'Missing details. Cannot search. db...too..much...info... *dies*';
								}


//									$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
//									$query = mysqli_real_escape_string($connection, $query);
//									$query = "SELECT * FROM user WHERE email='$query" //

							?>
						</table>

				</div>
			</div> <!-- row -->
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