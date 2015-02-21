<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
		require_once('Api.php');
		require_once('User.php');
		require_once('Post.php');
		require_once('Comment.php');
		require_once('Group.php');
		require_once('App.php');
	?>
	<?php
		define('CLIENT_ID', '4777791');
		define('CLIENT_SECRET', 'dqnkus3pkAwJxhq7CQMd');
		define('ID', '261061018');
		$app = new App();
		$app->client_id = CLIENT_ID;
		$app->secret_key = CLIENT_SECRET;
		// $url = $app->get_code_token();
		// $resp = $app->get_token('fa5e8d20c554cff8c8');
		// $data = json_decode($resp);
		$token = '1e15858ca0a85c0814f5baa4bfc70eff720dc52d4deafb2f5acc0f2d4807897df5a73d8d6f8f246990bcd';
		$user = Api::getUserInfo($token, 18858749);
		$groups = Api::getUserAdminGroupsName($token, 261061018);
		$posts = Api::getGroupTopics($token, 'twplab');
		// mpr($user);
	?>
</body>
</html>