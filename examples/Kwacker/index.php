<?
	require('../../classes/twitter/twiapi.php');

	session_start();
	$api = new TwiApi();

	$response = $api->GetUsersLookup("screen_name", "BananaaYogurt");
	$user = $response[0];

	$followers = $api->GetFollowersList("screen_name", "BananaaYogurt");

	$friends = $api->GetFriendsListByScreenName("BananaaYogurt");
?>
<!DOCTYPE html>
<head>
	<title>Kwacker</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

	<div id="ribbon">
		<img src="images/logo.png" id="logo"/>
		<img src="images/kwacker.png" id="kwacker" />
	</div>
	
	<div id="info">
		<h1>Account info</h1>
		<table>
			<tr>
				<td>ID</td>
				<td><? echo $user->id; ?></td>
				<td>Followers</td>
				<td><? echo $user->followers_count; ?></td>
			</tr>
			<tr>
				<td>Screen name</td>
				<td><? echo $user->name; ?></td>
				<td>Friends</td>
				<td><? echo $user->friends_count; ?></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><? echo $user->screen_name; ?></td>
				<td>Favourites</td>
				<td><? echo $user->favourites_count; ?></td>
			</tr>
		</table>
	</div>

	<div id="f">
		<div>
			<h1>Followers</h1>
			<table>
				<?
					for ($i=0; $i < count($followers); $i++)
					{
						echo "<tr>";
						echo "<td>".($i+1)."</td>";
						echo "<td>".$followers->users[$i]->name."</td>";
						$id = $followers->users[$i]->id;
						echo "<td><a href='ignore.php?id=$id'>Ignore</a></td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>
		<div>
			<h1>Following</h1>
			<table>
				<?
					for ($i=0; $i < count($friends); $i++)
					{
						echo "<tr>";
						echo "<td>".($i+1)."</td>";
						echo "<td>".$friends[$i]->name."</td>";
						$id = $friends[$i]->id;
						echo "<td><a href='unfollow.php?id=$id'>Unfollow</a></td>";
						echo "</tr>";
					}
				?>
			</table>
			<form method="get" action="follow.php">
				Screen name
				<input name="sn" type="text">
				<input class="b" type="submit" value="Follow">
			</form>
		</div>
	</div>
</body>