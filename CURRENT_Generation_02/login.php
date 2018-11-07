<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
	$email = (!empty($_POST['email'])) ? $_POST['email'] : false;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : false;
	if($email && $password){
		$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
		$email = mysqli_real_escape_string($connection, $email);
		$password = mysqli_real_escape_string($connection, $password);
		$query = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($connection, $query);
		if($result){
			$row = mysqli_fetch_array($result);
			$storedHash = $row[2];
		}
		$validateHash = $salt . $storedHash;
		for($i = 0; $i < 1; $i++){ $validateHash = hash('sha256', $validateHash);}
		$validateHash = $salt. $validateHash;
		$validateHash = substr($storedHash,0,64);
		$enteredHash = $salt . $password;
		for($i = 0; $i < 1; $i++){	$enteredHash = hash('sha256', $enteredHash);} // Look. Tiny code. I hope it's not too hard to understand. :|
		$userEnteredHash = substr($enteredHash,0,64);
		if($enteredHash == $validateHash){
			$_SESSION['username'] = $email;
			$_SESSION['password'] = $password;
			$_SESSION['Authenticated'] = true;
			$_SESSION['Expires'] = time() + 86400; // 24 hours.
			$_SESSION['isOnline'] = True; // omfg.

			$numberOne = 1;
			$isOnline = "UPDATE users SET isOnline='$numberOne' WHERE email='$email'";
				// Make online = True
			if(mysqli_query($connection, $isOnline)){
				echo 'User is online.';
			}else{
				echo 'Something went wrong...';
			}


			echo "Log in succesful.<br>Loading dashboard.";
			header("Location: dashboard.php");
		}else{header("Location: index.php?q=3");} // validated incorrectly.
	mysqli_close($connection);
	}else{ header("Location: index.php?q=2");} // Forgot to pass either: email || pass
?>