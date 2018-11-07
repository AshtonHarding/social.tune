<?php // Add / Decline friend
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php');

	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

	// userid && decline

	$requester_id = (!empty($_POST['requester_id'])) ? $_POST['requester_id'] : false;
	$decline = (!empty($_POST['decline'])) ? $_POST['decline'] : false;


	if($requester_id){
		if($decline == 2){ // Acceptance.
			$acceptRequest = "UPDATE friends SET pending='0' WHERE user_one = '$requester_id' AND user_two = '$user_id'";
			if(mysqli_query($connection, $acceptRequest)){
				echo "Added.";
				header("Location: notifications.php");
			}else{
				echo "Could not add.";
				echo '<a href="">Go back.</a> then let me know. - Ashton';
			}			
		}
		if($decline == 1){ // Decline.
			$declineRequest = "DELETE FROM friends WHERE user_one = '$requester_id' AND user_two = '$user_id'";
			if(mysqli_query($connection, $declineRequest)){
				echo "Decline.";
			}else{
				echo "Could not Decline.";
			}
		}
	}else{
		echo 'Something went wrong.';
	}

?>