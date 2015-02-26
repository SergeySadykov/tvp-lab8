<?php

class Message{

	public $id;
	public $from_id;
	public $date;
	public $text;
	public $reply_to_user;
	public $reply_to_comment;
	public $attachments = array();

	public static function getMessages($count = 20)
	{
		$data = App::api('messages.get', array(
			'count'=> $count,
		));

		return $data;
	}

}
