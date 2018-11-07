<?php // update-profile.php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/user-data.php');

/*
	Note: This is a pretty big file, and could get bigger. Don't worry too much about the size, I want
			us to make sure this thing is functional, and quick as possible. Feel free to edit and make
			things faster. Unit testing goes a long way. -- Ashton

*/

	$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
	$data = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");

	$bio = (!empty($_POST['bio'])) ? $_POST['bio'] : false;
	$country = (!empty($_POST['country'])) ? $_POST['country'] : false;
	$state = (!empty($_POST['state'])) ? $_POST['state'] : false;
	$town = (!empty($_POST['town'])) ? $_POST['town'] : false;

	$bio = mysqli_real_escape_string($connection, $bio);
	$country = mysqli_real_escape_string($connection, $country);
	$state = mysqli_real_escape_string($connection, $state);
	$town = mysqli_real_escape_string($connection, $town);

		/*---- Picture Update -----*/

	$file_name = $_FILES["DefaultPicture"]["name"];
	$file_ext = pathinfo($file_name);
	$new_file_name = $user_id.'.'.$file_ext['extension'];

	$file_path = $_SERVER['DOCUMENT_ROOT'] . '/socialtune/user-images/';

	if(!empty($file_name)){ // checks if file is actually being uploaded.
		if(is_dir($file_path)){ // checks if the DIR actually exists.
			if(is_writable($file_path)){ // Checks if the DIR can be written to.
				$uploaded = move_uploaded_file($_FILES['DefaultPicture']['tmp_name'], $file_path.$new_file_name);
				
				if($uploaded){
					echo 'File uploaded<br><br>';
				}else{
					echo 'File was not uploaded.';
				}
			}else{
				echo 'Upload DIR is not writable....But hey, at least it exists!';
			}
		}else{
			echo 'Upload DIR does not exist.<br /><br />';
		}
	}else{
		echo 'err...empty file... :|';
	}

	if(!$connection){
		due("SOMETHING WENT HORRIBLY WRONG. RUN AWAY. RUN FAR FAR AWAY.".mysqli_connect_error());
	}


		/*---- Bio Update -----*/

	if($bio){
		$update_bio = "UPDATE users SET bio='$bio' WHERE email='$email'";
		if(mysqli_query($connection, $update_bio)){
			echo "Update successful.<br />";
		}else{
			echo "Something went wrong -- ". mysqli_error($connection);
		}
	}

		/*---- Locations Updates -----*/
	if($country){
		$update_country = "UPDATE users SET location_country='$country' WHERE email='$email'";
		if(mysqli_query($connection, $update_country)){
			echo "Update successful.<br />";
		}else{
			echo "Something went wrong -- ". mysqli_error($connection);
		}
	}
	if($state){
		$update_state = "UPDATE users SET location_state='$state' WHERE email='$email'";
		if(mysqli_query($connection, $update_state)){
			echo "Update successful.<br />";
		}else{
			echo "Something went wrong -- ". mysqli_error($connection);
		}
	}
	if($town){
		$update_town = "UPDATE users SET location_town='$town' WHERE email='$email'";
		if(mysqli_query($connection, $update_town)){
			echo "Update successful.<br />";
		}else{
			echo "Something went wrong -- ". mysqli_error($connection);
		}
	}

		/*---- Inserts Picture Update -----*/

	if($uploaded){
		$update_photo = "UPDATE users SET default_image='$new_file_name' WHERE email='$email'";
		if(mysqli_query($connection, $update_photo)){
			echo "Update Successful.";
		}else{
			echo "Something went wrong -- ". mysqli_error($connection);
		}
	}

	header("Location: edit-profile.php");

	mysqli_close($connection); 
?>