<?
	//require "twiapi.php";

	//session_start();
	//if(!isset($_SESSION['target'])) header('Location: welcome.php');

	//$a = new TwiAPI();
?>
<!DOCTYPE html>
<head>
	<title>Kwacker <? //echo $_SESSION['target']; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
	<div id="ribbon">
		<img src="images/logo.png" id ="logo"/>
		<img src="images/kwacker.png" id = "kwacker"/>
	</div>
	<div id="wrapper">
		<h1>Account info</h1>
		<?
			//$creds = $a->verifyCredentials();
			//var_dump($creds);
		?>
		<h3>ID</h3>
		<h3><? //echo $creds->id; ?></h3>
		<h3>Name</h3>
	</div>
		<div class = "followers">
			<h1>Followers</h1>
			<table class="maintable">
				<tr>
					<td>Name follower</td>
					<td><a href="#" class="myButton"><img src="images/ignore.png" /><h4>Ignore</h4></a></button></td>
				</tr>
			</table>
		</div>
		<div class = "following">
			<h1>Following</h1>
			<table class="maintable">
				<tr>
					<td>Name following</td>
					<td><a href="#" class="myButton"><img src="images/ignore.png" /><h4>Unsubscribe</h4></a></button></td>
				</tr>
				<tr>
					<td><input type="text" value="Username"/></td>
					<td><a href="#" class="myButton"><img src="images/logo.png" /><h4>Follow ...</h4></a></button></td>
				</tr>
			</table>
		</div>
</body>