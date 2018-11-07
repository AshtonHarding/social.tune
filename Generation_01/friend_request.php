<?php // Send friend request
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php');

/*
	This could be good. May need to change it up in the future. I'm very concerned about scaling. -- Ashton
*/
	
	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

	$profile_id_request = (!empty($_POST['profile_id'])) ? $_POST['profile_id'] : false; // Grabs the requesters' ID.
	$remove = (!empty($_POST['remove'])) ? $_POST['remove'] : false;

	$profile_id_friend_request = mysqli_real_escape_string($connection, $profile_id_request); // simple security.
	$remove = mysqli_real_escape_string($connection, $remove);

	$numberOne = 1; // hmh. Not really needed, but variables.

	if($remove){ // Remove friend.
		if($profile_id_friend_request){
			$remove_friend = "DELETE FROM friends 
				WHERE user_one='$user_id' AND user_two='$profile_id_friend_request'
				OR user_one='$profile_id_friend_request' AND user_two='$user_id'";
			if(!mysqli_query($connection, $remove_friend)){
				die("err... You aren't friends.");
			}
			echo "DELETED THIS MOTHERFUCKER. GG";
		}
	}

	if($remove == false){ // Add friend.
		if($profile_id_friend_request){
			$send_friend_request = "INSERT INTO friends(user_one, user_two, pending)
				VALUES
				('$user_id','$profile_id_friend_request','$numberOne')";
			if(!mysqli_query($connection, $send_friend_request)){
				die("You are already friends.");
			}
			echo "Friend request sent.";
		}
	}

	
?>