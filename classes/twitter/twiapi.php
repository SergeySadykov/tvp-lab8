<?
	require "TwitterOAuth/autoload.php";

	use Abraham\TwitterOAuth\TwitterOAuth;

	define(CONSUMER_KEY, 'Jky813XwbmOXCiE3barLsq5QT');
	define(CONSUMER_SECRET, 'AtgwEFXAblqEccb3WlKM1tINz8aqF8TZP3T2UZ0kH9UQBhCDDY');
	define(OAUTH_CALLBACK, 'oob');

	class TwiApi
	{
		public $connection;

		function __construct()
		{
			session_start();
			$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
			$requestToken = $this->connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
			$_SESSION['oauthToken'] = $requestToken['oauth_token'];
			$_SESSION['oauthTokenSecret'] = $requestToken['oauth_token_secret'];
		}

		function GetFollowersIds($param, $val)
		{
			return $this->connection->get("followers/ids", array($param => $val))->ids;
		}

		function GetFollowersList($param, $val)
		{
			return $this->connection->get("followers/list", array($param => $val));
		}

		function GetAccountSettings()
		{
			$response = $this->connection->get("account/settings");
			$result = $response;
			return $result;
		}

		function GetUsersLookup($param, $val)
		{
			return $this->connection->get("users/lookup", array($param => $val));
		}

		function GetFriendsIdsByScreenName($sn)
		{
			$response = $this->connection->get("friends/ids", array("screen_name" => $sn));
			$result = $response->ids;
			return $result;
		}

		function GetFriendsListByScreenName($sn)
		{
			$response = $this->connection->get("friends/list", array("screen_name" => $sn));
			$result = $response->users;
			return $result;
		}
	}
?>