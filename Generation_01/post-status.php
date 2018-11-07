<?php /* creates entry for status */

	ini_set('display_errors', '1');

	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php');

	/* Which are we using today? */
	$isRemoval = (!empty($_POST['removal'])) ? $_POST['removal'] : false;
	$post_id = (!empty($_POST['post_id'])) ? $_POST['post_id'] : false;

	//$post_id = (!empty($_POST['post_id'])) ? $_POST['post_id'] : false;
	$poster_id = $user_id;
	$message = (!empty($_POST['message'])) ? $_POST['message'] : false;

	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


	if($isRemoval){
		$post_id = (!empty($_POST['post_id'])) ? $_POST['post_id'] : false;

		$isRemoval = mysqli_real_escape_string($connection, $isRemoval);
		$post_id = mysqli_real_escape_string($connection, $post_id);

		if($post_id){
			$delete_status_now = "DELETE FROM status
			WHERE id='$post_id' AND poster_id='$user_id'";
			if(!mysqli_query($connection, $delete_status_now)){
				die("Error.");
			}
			echo "deleted status.";
		}else{
			echo 'Something went wrong. -- removal.';
		}

	}else{
			/* Status Creation */

		$poster_id = mysqli_real_escape_string($connection, $poster_id);
		$message = mysqli_real_escape_string($connection, $message);


		var_dump($poster_id);

		if($poster_id && $message){
			$add_status = "INSERT INTO status(poster_id, message)
				VALUES
				('$poster_id','$message')";
			if(!mysqli_query($connection, $add_status)){
				die("err....wat");
			}
			Header("Location: dashboard.php");
		}else{
			echo "Error: Either you're not logged in, or forgot to enter text.";
			Header("Location: dashboard.php?ps=1");
		}
	}

	Header("Location: dashboard.php");

?>