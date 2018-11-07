<?php
	//Logout.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php'); 

			// Turn off: isOnline.
	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
	$query = "SELECT * FROM users WHERE email='$user_email'";
	$result = mysqli_query($connection, $query);
	if($result){
		$numberZero = 0;
		$isOnline = "UPDATE users SET isOnline='$numberOne' WHERE email='$email'";
		if(mysqli_query($connection, $isOnline)){
			echo 'User is online.';
			mysqli_close($connection);
		}else{
			echo 'Something went wrong...';
			mysqli_close($connection);
		}
	}



	session_destroy();
	header("Location: index.php?p=4");
?>