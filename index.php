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
	?>
	<?php



		define('CLIENT_ID', '4777791');
		define('CLIENT_SECRET', 'dqnkus3pkAwJxhq7CQMd');
		define('ID', '261061018');
		$app = new App();
		$app->client_id = CLIENT_ID;
		$app->secret_key = CLIENT_SECRET;
		// $url = $app->get_code_token();
		// var_dump($url);
		// $resp = $app->get_token('fa5e8d20c554cff8c8');
		// $data = json_decode($resp);
		$app->token = '1e15858ca0a85c0814f5baa4bfc70eff720dc52d4deafb2f5acc0f2d4807897df5a73d8d6f8f246990bcd';
		$url = 'https://api.vk.com/method/users.get?user_id='.ID.'&fields=sex, bdate, city, country, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, photo_id, online, online_mobile, domain, has_mobile, contacts, connections, site, education, universities, schools, can_post, can_see_all_posts, can_see_audio, can_write_private_message, status, last_seen, common_count, relation, relatives, counters, screen_name, maiden_name, timezone, occupation,activities, interests, music, movies, tv, books, games, about, quotes, personal, friends_status&v=5.28&access_token='.$app->token;
		$data = $app->call($url);
		$user = new User($data[0]);
		$user->getUserInfo();
	?>
	<!-- <a href="<?=$url?>">Получить token</a> -->
	<img src="<?=$data[0]['photo_200']?>">
	<!-- <p><?=$info->first_name?></p> -->
</body>
</html>