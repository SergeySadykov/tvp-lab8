<?
	require "twiapi.php";

	session_start();
	if(!isset($_SESSION['target'])) header('Location: welcome.php');

	$a = new TwiAPI();
?>
<!DOCTYPE html>
<head>
	<title>ТВП — Пользователь <? echo $_SESSION['target']; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
	<div id="ribbon">
		<table>
			<tr>
				<td><img src="images/logo.png" /></td>
				<td><h1>ТВП — Пользователь</h1></td>
				<td><a href="logout.php"><? echo $_SESSION['target']; ?></a></td>
			</tr>
		</table>
	</div>
	<div id="wrapper">

		<h1>Сводная информация</h1>
		<?
			$creds = $a->verifyCredentials();
			var_dump($creds);
		?>
		<table>
			<tr>
				<td>ID</td>
				<td><? echo $creds->id; ?></td>
			</tr>
			<tr>
				<td>Полное имя</td>
				<td></td>
			</tr>
		</table>

		<h1>Подписчики</h1>
		<table class="followers">
			<tr>
				<td>1</td>
				<td>2</td>
				<td>3</td>
			</tr>
			<tr>
				<td>4</td>
				<td>5</td>
				<td>6</td>
			</tr>
		</table>

	</div>
</body>