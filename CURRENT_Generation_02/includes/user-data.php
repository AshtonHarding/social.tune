<?php /* Handles all the data for the user. */
	ini_set('display_errors', '1');

	if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']){
		if($_SESSION['Expires'] < time()){
			// Log out here.
			exit();
			header("Location: logout.php");
		}
		$_SESSION['Expires'] = time() + 86400; // if logged in, set to 24 hours.
	}

	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 


	/* sets session variables. */

	$email = $_SESSION['username'];

	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
	$data = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");

	if($data){
		$row = mysqli_fetch_array($data, MYSQLI_NUM);
		$user_id = $row[0];
		$user_email = $row[1];
		//$user_password = $row[2]; // Don't make this available. pls.
		$user_First_Name = $row[3];
		$user_Last_Name = $row[4];
		$user_birthdate = $row[5];
		$user_country = $row[6];
		$user_state = $row[7];
		$user_town = $row[8];
		$user_signup = $row[9];
		$user_bio = $row[10];
		$user_image_ext = $row[11];
		$user_isOnline = $row[13];

	}else{
		echo "The data didn't go through.";
	}

				/*-- Notification Check --*/

	$pending_notification = 0;
	
	$query = "SELECT * FROM friends WHERE user_two='$user_id' AND pending='1'";
	$requests = mysqli_query($connection, $query);

	if(mysqli_num_rows($requests) > 0){
		$pending_notification = 1;
	}else{
		$pending_notification = 0;
	}

?>