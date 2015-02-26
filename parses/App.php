<?php

function mpr($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

class App
{
	const TOKEN = 'de840540210806d354dc4c7f032bfb50f60cdb78df41d377c212244fe9bcfdcb523db605d2022adb62b30';
	const API_VERSION = '5.28';
	const CALLBACK_BLANK = 'https://oauth.vk.com/blank.html';
	const AUTHORIZE_URL = 'https://oauth.vk.com/authorize?client_id={client_id}&scope={scope}&redirect_uri={redirect_uri}&display={display}&v=5.28&response_type={response_type}';
	const GET_TOKEN_URL = 'https://oauth.vk.com/access_token?client_id={client_id}&client_secret={client_secret}&code={code}&redirect_uri={redirect_uri}';
	const METHOD_URL = 'https://api.vk.com/method/';
	const SECRET_KEY = 'dqnkus3pkAwJxhq7CQMd';
	const SCOPE = array('groups,wall,friends,photos,audio,video,docs,notes,pages,status,messages,email,notifications,stats,offline');
	const CLIENT_ID = '4777791';

	public static function get_code_token($type="code")
	{
		$url = self::AUTHORIZE_URL;
		$scope = implode(',', self::SCOPE);
		$url = str_replace('{client_id}', self::CLIENT_ID, $url);
		$url = str_replace('{scope}', $scope, $url);
		$url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
		$url = str_replace('{display}', 'page', $url);
		$url = str_replace('{response_type}', $type, $url);
		return $url;
	}

	public static function get_token($code)
	{
		$url = self::GET_TOKEN_URL;
		$url = str_replace('{code}', $code, $url);
		$url = str_replace('{client_id}', self::CLIENT_ID, $url);
		$url = str_replace('{client_secret}', self::SECRET_KEY, $url);
		$url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
		return self::call($url);
	}

	private static function call($url = '')
	{
		if(function_exists('curl_init'))
			$json = self::curl_post($url);
		else
			$json = file_get_contents($url);
		$json = json_decode($json, true);
		if(isset($json['response']))
			return $json['response'];
		return $json;
	}

	private static function curl_get($url)
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

	private static function curl_post($url)
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

	public function api($method = '', $vars = array())
	{
		$vars['v'] = self::API_VERSION;
		$params = http_build_query($vars);
		$url = self::http_build_query($method, $params);
		return (array)self::call($url);
	}

	private static function http_build_query($method, $params = '')
	{
		return self::METHOD_URL.$method.'?'.$params.'&access_token='.self::TOKEN;
	}

	public static function upload_photo($gid = false, $files = array())
	{
		$gid = substr(Other::getPlusMinusId($gid),1);
		if(count($files) == 0) return false;
		if(!function_exists('curl_init')) return false;

		$data_json = self::api('photos.getWallUploadServer', array('group_id'=> intval($gid)));
		if(!isset($data_json['upload_url'])) return false;

		$temp = array_chunk($files, 4);
		$files = array();
		foreach ($temp[0] as $key => $data)
		{
			$path = realpath($data);
			if($path)
			{
				$files['file' . ($key+1)] = (class_exists('CURLFile', false)) ? new CURLFile(realpath($data)):'@'. realpath($data);
			}
		}

		$upload_url = $data_json['upload_url'];
		$ch = curl_init($upload_url);
		$useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3';
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
		curl_setopt($ch, CURLOPT_HEADER, 0);
	  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $files);

		$upload_data = json_decode(curl_exec($ch), true);
		$upload_data['group_id'] = intval($gid);
		$response = self::api('photos.saveWallPhoto', $upload_data);
		$attachments = array();
		if(count($response) > 0)
		{
		   foreach($response as $photo)
		   {
		 		$attachments[] = $photo['id'];
			}
		}
		return $attachments;
	}
}