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
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SocialTune | Edit Profile</title>

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
					<li><a href="dashboard.php">Home</a></li>
					<?php if($pending_notification == 1){
						echo '<li><span class="relative_blink"><span class="notification_blink"><span class="online_blink">New</span></span></span><a href="notifications.php">Notifications</a></li>'; 
						}else{ echo '<li><a href="notifications.php">Notifications</a><li>';	} // HOLY SHIT THIS IS A CLUSTERFUCK OF BAD. ~~ Ashton
					?>
					<li><?php echo'<a href="profile.php?id='.$user_id.'">View Profile</a>'; ?></li>
					<li class="active"><a href="edit-profile.php">Edit Profile</a></li>
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
				Oh..Hi. Go ahead. Edit something.
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form method="POST" action="update-profile.php" enctype="multipart/form-data">
					<?php
						// These might not even really be needed. I'll keep them here for the time being.
					$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
					$uploadHandler = $_SERVER['HTTP_HOST'] . $directory_self . 'update-profile.php';

					$MAX_FILE_SIZE = 300000000; // file size (bytes). Can improve. Later.

						// limitations for photo.
					?>
						<div class="form-group">
							<?php echo '<img src="user-images/'.$user_image_ext.'" style="width: 150px; height: 150px; float: left; margin: 1em 1em 1em 1em;">'; ?>
							<label for="DefaultPicture"><br />Change profile picture</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $MAX_FILE_SIZE; ?>">
							<input type="file" name="DefaultPicture" id="DefaultPicture">
							<p class="help-block"><br /><br />Nice face~ ° ͜ʖ ͡° </p>
						</div>


						<div class="form-group">
							<?php 
								echo 'New bio: <br />';
								echo '<textarea type="bio" class="form-control" rows="6" name="bio" id="bio" placeholder="'.$user_bio.'"></textarea>';
							?>
						</div>

						<div class="form-group">
							<?php
								echo 'Country: <br />';
								echo '<input type="country" class="form-control" name="country" id="country" placeholder="'.$user_country.'">';
								echo 'State: <br />';
								echo '<input type="state" class="form-control" name="state" id="state" placeholder="'.$user_state.'">';
								echo 'City/Town: <br />';
								echo '<input type="town" class="form-control" name="town" id="town" placeholder="'.$user_town.'">';
							?>
						</div>

						<div class="col-xs-4"></div>
						<div class="col-xs-4"></div>
						<div class="col-xs-4">
							<center><button type="submit" class="btn btn-primary">Save Changes</button></center>
						</div>

					</form>

				</div>
				<div class="col-md-3"></div>
			</div>





			</div>


			<?php /*
				echo 'user id: '.$user_id.'<br><br>';
				echo 'user email: '.$user_email.'<br><br>';
				echo 'user first name: '.$user_First_Name.'<br><br>';
				echo 'user last name: '.$user_Last_Name.'<br><br>';
				echo 'user bday:'.$user_birthdate.'<br><br>';
				echo 'user bio:<br><p>'.$user_bio.'</p><br>';
				*/
			?>

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