<!DOCTYPE html>
<head>
	<title>ТВП — Ошибка</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
	<div id="ribbon">
		<table>
			<tr>
				<td><img src="images/logo.png" /></td>
				<td><h1>ТВП — Вход</h1></td>
			</tr>
		</table>
	</div>
	<div id="wrapper">
		<h1>Произошла ошибка :(</h1>
		<h2>Код ошибки - <? echo $_GET['errcode']; ?></h2>
	</div>
</body>