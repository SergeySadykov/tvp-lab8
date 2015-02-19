<?php

function mpr($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

class App
{
	const API_VERSION = '5.24';
	const CALLBACK_BLANK = 'https://oauth.vk.com/blank.html';
	const AUTHORIZE_URL = 'https://oauth.vk.com/authorize?client_id={client_id}&scope={scope}&redirect_uri={redirect_uri}&display={display}&v=5.24&response_type={response_type}';
	const GET_TOKEN_URL = 'https://oauth.vk.com/access_token?client_id={client_id}&client_secret={client_secret}&code={code}&redirect_uri={redirect_uri}';
	const METHOD_URL = 'https://api.vk.com/method/';

	public $secret_key = null;
	public $scope = array();
	public $client_id = null;
	public $access_token = null;
	public $token = null;

	public function __construct($options = array())
	{
		$this->scope[]='offline';
		$this->scope[]='groups';
		if(count($options) > 0)
		{
			foreach($options as $key => $value)
			{
				if($key == 'scope' && is_string($value))
				{
					$_scope = explode(',', $value);
					$this->scope = array_merge($this->scope, $_scope);
				}
				else
				{
					$this->$key = $value;
				}
			}
		}
	}

	public function get_code_token($type="code")
	{
		$url = self::AUTHORIZE_URL;
		$scope = implode(',', $this->scope);
		$url = str_replace('{client_id}', $this->client_id, $url);
		$url = str_replace('{scope}', $scope, $url);
		$url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
		$url = str_replace('{display}', 'page', $url);
		$url = str_replace('{response_type}', $type, $url);
		return $url;
   }

   public function get_token($code)
   {
   	$url = self::GET_TOKEN_URL;
   	$url = str_replace('{code}', $code, $url);
   	$url = str_replace('{client_id}', $this->client_id, $url);
   	$url = str_replace('{client_secret}', $this->secret_key, $url);
   	$url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
   	return $this->call($url);
   }

   function call($url = '')
   {
		if(function_exists('curl_init'))
			$json = $this->curl_post($url);
		else
			$json = file_get_contents($url);
		$json = json_decode($json, true);
		if(isset($json['response']))
			return $json['response'];
		return $json;
	}

	private function curl_get($url)
	{
		if(!function_exists('curl_init'))
			return false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$tmp = curl_exec ($ch);
		curl_close ($ch);
		$tmp = preg_replace('/(?s)<meta http-equiv="Expires"[^>]*>/i', '', $tmp);
		return $tmp;
	}

	private function curl_post($url)
	{
		if(!function_exists('curl_init'))
			return false;
		$param = parse_url($url);
		if( $curl = curl_init() )
		{
			curl_setopt($curl, CURLOPT_URL, $param['scheme'].'://'.$param['host'].$param['path']);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $param['query']);
			$out = curl_exec($curl);
			curl_close($curl);
			return $out;
		}
		return false;
	}
}
