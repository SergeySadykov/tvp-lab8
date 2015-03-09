<?
	require "TwitterOAuth/autoload.php";

	use Abraham\TwitterOAuth\TwitterOAuth;

	define('CONSUMER_KEY', 'KvAThjn4hAN6vEal7bGu5saJN');
	define('CONSUMER_SECRET', 'Q81GWNiOjTfGr8wlDF0uyeh7Rto3hxSdVKHRC9sawTctrE0n9M');

	function GetFollowersIds()
	{
		/*session_start();
		$connection = new TwitterOAuth("CONSUMER_KEY",
			"CONSUMER_SECRET");
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		$url = $connection->getAuthorizeURL($token);

		$connection = new TwitterOAuth("CONSUMER_KEY",
			"CONSUMER_SECRET",
			$_SESSION['oauth_token'],
			$_SESSION['oauth_token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		$_SESSION['access_token'] = $access_token;

		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		$connection = new TwitterOAuth('CONSUMER_KEY',
			'CONSUMER_SECRET',
			$access_token['oauth_token'],
			$access_token['oauth_token_secret']);

		$content = $connection->get('followers/ids');
		var_dump($content);*/

		$connection = new TwitterOAuth("CONSUMER_KEY",
			"CONSUMER_SECRET");
		$access_token = $connection->oauth("oauth/access_token",
			array("oauth_verifier" => 'CONSUMER_KEY'));
		var_dump($access_token);
	}

	GetFollowersIds();
?>