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

		// Here is the profile grabbing shit. >.>
	$profile_id = (!empty($_GET['id'])) ? $_GET['id'] : false;


	if($profile_id){
		$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
		$profile_id = mysqli_real_escape_string($connection, $profile_id);

		$data = mysqli_query($connection, "SELECT * FROM users WHERE id='$profile_id'");
		if($data){
			$row = mysqli_fetch_array($data, MYSQLI_NUM);
			$profile_First_Name = $row[3];
			$profile_Last_Name = $row[4];
			$profile_birthdate = $row[5];
			$profile_country = $row[6];
			$profile_state = $row[7];
			$profile_town = $row[8];
			$profile_signup = $row[9];
			$profile_bio = $row[10];
			$profile_image_ext = $row[11];
			$profile_isOnline = $row[13];
		}else{
			echo "The data didn't go through";
		}
		if(mysqli_num_rows($data) > 0){

		} else{
			header("Location: index.php");
		}

	}else{
		header("Location: dashboard.php");
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
					?>					<li class="active"><?php echo'<a href="profile.php?id='.$user_id.'">View Profile</a>'; ?></li>
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
				<div class="col-md-8">
					<br />
					<?php echo '<img src="user-images/'.$profile_image_ext.'" style="width: 150px; height: 150px; float: left; margin: 1em 1em 1em 1em;">'; ?>
					<?php
						// grabs age.

						$profile_age = date_diff(date_create($profile_birthdate), date_create('now'))->y;


						if($profile_isOnline == 1){echo '<sup><span class="online_blink_bg"><span class="online_blink">Online</span></span></sup>';}else{echo '<sup><span class="offline_blink_bg"><span class="offline_blink">Offline</span></span></sup>';}
						echo '<b> '.$profile_First_Name.' '.$profile_Last_Name.'</b><br />';
						echo 'Age: <b>'.$profile_age.'</b><br />';
						echo 'Town: ';
						if($profile_town == false){echo '[unlisted]<br />';}else{echo $profile_town.'<br />';}
						echo 'State: ';
						if($profile_state == false){echo '[unlisted]<br />'; }else{echo $profile_state.'<br />'; }
						echo 'Country: ';
						if($profile_country == false){echo '[unlisted]<br />'; }else{echo $profile_country.'<br />'; }
					?>
					<?php echo '<u>bio</u>:<br />';
						echo '<p>'.$profile_bio.'</p>'; 
					?>

					<br>

					<u><h3>Garbled Transmission:</h3></u>

					<?php
						/* Ok.. This is the status stuff. :| */
						$status_query = "SELECT * FROM status WHERE poster_id='$profile_id' ORDER BY post_date DESC";

						$get_status = mysqli_query($connection, $status_query);

						while($status_row = mysqli_fetch_array($get_status, MYSQLI_NUM)){
							$status_id = $status_row[0];
							$status_owner = $status_row[1];
							$status_date = $status_row[2];
							$status_body = $status_row[3];



							$status_user_data = "SELECT * FROM users WHERE id='$status_owner'"; // ORDER BY isn't working?
							$get_status_user_data = mysqli_query($connection, $status_user_data);

							while($status_user = mysqli_fetch_array($get_status_user_data, MYSQLI_NUM)){
								$status_owner_name = $status_user[3].' '.$status_user[4];
								$status_owner_picture = $status_user[11];
							}

							echo '<table class="table table-bordered"><tr>';
							echo '<tbody><img style="width: 30px; height:30px;" src="user-images/'.$status_owner_picture.'">'.$status_owner_name.'
								<sub style="float:right;margin-top:15px;"><sub>'.$status_date.'</sub></sub></tbody></tr>';
							echo '<tr><td>'.$status_body.'</td></tr></table>';
						}

					?>
					</table>



				</div>
				<div class="col-md-4">
					<center><h3><?php echo '<a href="friends.php?id='.$profile_id.'">Friends List</a>'; ?></h3></center>	
							<?php 
								$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
								$isPending = 0;
								$query = "SELECT * FROM friends WHERE user_two='$profile_id' AND pending='$isPending' OR user_one='$profile_id' AND pending='$isPending' LIMIT 6";
								$get_friends = mysqli_query($connection, $query);
								$counter = 0;

								$data = mysqli_query($connection, $query);

								if(mysqli_num_rows($data) > 0){ // Checks if they have friends.
									while($row = mysqli_fetch_array($get_friends, MYSQLI_NUM)){
										$friend_A = $row[1];
										$friend_B = $row[2];

										if($friend_A == $profile_id){
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

										if($counter == 0 || $counter == 3){ echo '<div class="col-md-6">';}

										echo'<table class="table table-bordered"><tr><td><a href="profile.php?id='.$friend_info_id.'"><img style="width:100px; height:100px;" src="user-images/'.$friend_info_img.'">';
											if($friend_info_online == 1){
												echo '<sup><span class="online_blink_bg"><span class="online_blink">Online</span></span></sup></a></td></tr>';
											}else{
												echo'<sup><span class="offline_blink_bg"><span class="offline_blink">Offline</span></span></sup></a></td></tr>';
											}
										echo '<tr><td><a style="font-size: 10px;" href="profile.php?id='.$friend_info_id.'">'.$friend_info_name.'</a></td></tr>';
										if($counter == 2 || $counter == 5){
											echo '</table></div>';
										}

										$counter = $counter + 1;

									}
								}else{
									// no friends lol...
								}
							?>
							</table>

				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				&nbsp;
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">

			<?php

			if(mysqli_num_rows($data) > 0){ // Checks if they have friends.

				if($profile_id == $user_id){
					// nothing.
				}else{
					//$isFriend = "SELECT * FROM friends WHERE user_two='$profile_id' AND pending='$isPending' OR user_one='$profile_id' AND pending='$isPending'";
					if($friend_A == $user_id || $friend_B == $user_id){
						echo '
						<form method="POST" action="friend_request.php">
							<div class="form-group">
								<input type="hidden" name="profile_id" id="profile_id" value="'.$profile_id.'">
								<input type="hidden" name="remove" id="remove" value="True">
							</div>
							<button type="submit" class="btn btn-primary">Delete Friends</button>
						</form>
						';
					}else{
						echo '
						<form method="POST" action="friend_request.php">
							<div class="form-group">
								<input type="hidden" name="profile_id" id="profile_id" value="'.$profile_id.'">
							</div>
							<button type="submit" class="btn btn-primary">Add Friend</button>
						</form>
						';
					}

				}
			}else{
				echo '
					<form method="POST" action="friend_request.php">
						<div class="form-group">
							<input type="hidden" name="profile_id" id="profile_id" value="'.$profile_id.'">
						</div>
						<button type="submit" class="btn btn-primary">Add Friend</button>
					</form>
				';
			}
			?>

				</div>
			</div>

		</div>
	</div>
	<div class="container">
		<div class="jumbotron">

		<div id="push"></div>
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