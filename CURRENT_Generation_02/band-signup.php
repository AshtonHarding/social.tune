<?php 
	ini_set('display_errors', '1');

	if(isset($_SESSION['Authenticated']) && $_SESSION['Authenticated']){
		if($_SESSION['Expires'] < time()){
			// Log out here.
			exit();
			header("Location: logout.php");
		}
		$_SESSION['Expires'] = time() + 86400; // if logged in, set to 24 hours.
		header("Location: Dashboard.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SocialTune | Band Signup</title>

	<!--// bootstrap //-->
	<link href="css/bootstrap.css" rel="stylesheet">
	
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
					<li><a href="index.php">Login</a></li>
					<li class="active"><a href="signup.php">Signup</a></li>
					<li><a href="about.php">About</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!--// Content //-->
	<div class="container">
	<div class="jumbotron">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-4">
				<!--// Add signup. //-->

				<form method="POST" action="register.php">

					<div class="form-group">
						<div class="col-xs-12">
							<input type="hidden" name="is_Band" id="is_band" value="true">
							<input type="band_name" class="form-control" name="band_name" id="band_name" placeholder="Band Name">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<input type="email" class="form-control" name="email" id="email" placeholder="Email">
						</div>
						<div class="col-xs-6"></div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						</div>
					</div>

						<br />
					
					<div class="form-group">
						<div class="col-xs-12">
							<center><h2>Band Start Date</h2></center>
						</div>
						<div class="col-xs-4"> <!--// Month //-->
							<select class="form-control" style="font-size:12px;" name="month">
								<option>Month</option>
								<option>01</option>
								<option>02</option>
								<option>03</option>
								<option>04</option>
								<option>05</option>
								<option>06</option>
								<option>07</option>
								<option>08</option>
								<option>09</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>
							</select>
						</div>
						<div class="col-xs-4"> <!--// Day //-->
							<select class="form-control" style="font-size:12px;" name="day">
								<option>Day</option>
							<?php 
								$month = 1;
								while($month <= 31){
									echo '<option>'.$month.'</option>';
									$month = $month + 1;
								}
							?>
							</select>
						</div>
						<div class="col-xs-4"> <!--// Year //-->
							<select class="form-control" style="font-size:12px;" name="year">
							<option>Year</option>
							<?php 
								$year = 2015;
								while($year >= 1900){
									echo '<option>'.$year.'</option>';
									$year = $year - 1;
								}
							?>
							</select>
						</div>
					</div>

					<div class="col-xs-12">
					<p style="font-size: 10px;"><br />By clicking "Sign up", you agree to our <a href="">terms of service</a> and that you allow your computer to enjoy our <a href="">cookies</a>.</p>
						<center><button type="submit" class="btn btn-primary">Sign up</button></center>
					</div>

				</form>
			</div>

			</div>
			<br />
			<p style="font-size: 8px;">Are you a <a href="signup.php">not a band</a>?</p>

		</div>
		</div>

		<?php // if the email is already in use.
			$inUse = (!empty($_GET['q'])) ? $_GET['q'] : false;

			if($inUse){
				echo '<center><h2>The email is already registered. Try a different one or <a href="index.php">login</a></h2></center>';
			}



		 ?>

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