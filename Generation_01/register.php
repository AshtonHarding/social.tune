<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/session.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/socialtune/includes/config.php'); 
/* ## On security...
 * Change the encryption method. >> bcrypt 
 OR
 SHA-256 + per-user salt.

*/

 	$is_band = (!empty($_POST['is_Band'])) ? $_POST['is_Band'] : false;


			/********************************************
			*****	-------------------------------		*
			*****	### NORMA USER SIGN UP PART ####	*
			*****	-------------------------------		*
			*********************************************/

	if($is_band == false){

		$first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : false;
		$last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : false;
		$email = (!empty($_POST['email'])) ? $_POST['email'] : false;
		$password = (!empty($_POST['password'])) ? $_POST['password'] : false;
		$month = (!empty($_POST['month'])) ? $_POST['month'] : false;
		$day = (!empty($_POST['day'])) ? $_POST['day'] : false;
		$year = (!empty($_POST['year'])) ? $_POST['year'] : false;

			// Disallow "text entry"

		if(is_string($month)){
			$month = false;
		}
		if(is_string($day)){
			$day = false;
		}
		if(is_string($year)){
			$year = false;
		}
		

			// Convert to proper input.
		$birthdate = $month."/".$day."/".$year;

		$date = getdate();
		$signup_date = $date['mon'].'/'.$date['mday'].'/'.$date['year'];


		if($first_name && $last_name && $email && $password && $year && $day && $year){
			$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName); // variables provided /include/.
			$storedHash = $salt . $password;
			for($i = 0; $i < 1; $i++){
				$storedHash = hash('sha256', $storedHash);
			}
			$officialHash = substr($storedHash, 0, 64);
			$password = $officialHash;
			if(mysqli_connect_error()){
				echo "ERROR #001 - ".mysqli_connect_error; // Didn't connect. Check all settings.
			}
			$command = "INSERT INTO users(first_name, last_name, email, password, birthdate, signup_date)
			VALUES
			( '$first_name', '$last_name', '$email', '$password', '$birthdate', '$signup_date')";
			if(!mysqli_query($connection, $command)){
				die("This email is already registered.");
				header("Location: signup.php?q=1"); // NOT SO MUCH READY TO GO. WTF DUDE GET AN EMAIL BR0.
			}
			echo "Signup complete... You are being redirected.";
			header("location: index.php?q=1"); // Ready to go!!!

		}else{
			echo "Missing data. -- Normal user";
			header("Location: signup.php?q=2"); // Normal user - Forgot to input something.
		}
	}




			/********************************************
			*****	--------------------------			*
			*****	### BAND SIGN UP PART ####			*
			*****	--------------------------			*
			*********************************************/

	if($is_band){

		$band_name = (!empty($_POST['band_name'])) ? $_POST['band_name'] : false;
		$email = (!empty($_POST['email'])) ? $_POST['email'] : false;
		$password = (!empty($_POST['password'])) ? $_POST['password'] : false;
		$month = (!empty($_POST['month'])) ? $_POST['month'] : false;
		$day = (!empty($_POST['day'])) ? $_POST['day'] : false;
		$year = (!empty($_POST['year'])) ? $_POST['year'] : false;

			
			/*---- Disallow "text entry" ----*/
		if(ctype_alpha($month)){
			$month = false;
			echo 'something went wrong with the month entry.<br>';
		}
		if(ctype_alpha($day)){
			$day = false;
			echo 'something went wrong with the day entry.<br>';
		}
		if(ctype_alpha($year)){
			$year = false;
			echo 'something went wrong with the year entry.<br>';
		}

			// Converts to proper input.
		$birthdate = $month."/".$day."/".$year;

		$date = getdate();
		$signup_date = $date['mon'].'/'.$date['mday'].'/'.$date['year'];



		if($band_name && $email && $password && $month && $day && $year){
			$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName); // variables provided /include/.
			$storedHash = $salt . $password;
			for($i = 0; $i < 1; $i++){
				$storedHash = hash('sha256', $storedHash);
			}
			$officialHash = substr($storedHash, 0, 64);
			$password = $officialHash;
			if(mysqli_connect_error()){
				echo "ERROR #001 - ".mysqli_connect_error; // Didn't connect. Check all settings.
			}
			$command = "INSERT INTO users(first_name, email, password, birthdate, signup_date, user_type)
			VALUES
			( '$band_name', '$email', '$password', '$birthdate', '$signup_date', '$is_band')";
			if(!mysqli_query($connection, $command)){
				die("This email is already registered.");
				// header("Location: signup.php?q=1"); // NOT SO MUCH READY TO GO. WTF DUDE GET AN EMAIL BR0.
			}
			echo "Signup complete... You are being redirected.";
			header("location: index.php?q=1"); // Ready to go!!!

		}else{
			echo "Missing data. -- band users. <br /><br />";
			header("Location: signup.php?q=1"); // NOT SO MUCH READY TO GO. WTF DUDE GET AN EMAIL BR0.
		}
	}



?>