<?php
	class Post{

		public $id;
		public $owner_id;
		public $from_id;
		public $date;
		public $text;
		public $reply_owner_id;
		public $reply_post_id;
		public $friends_only;
		public $comments = array();
		public $likes = array();
		public $reposts = array();
		public $post_type;
		public $post_source = array();
		public $attachments = array();
		public $geo = array();
		public $signer_id;
		public $copy_history = array();
		public $can_pin;
		public $is_pinned;

		public function __construct($a)
		{
			if (!empty($a))
			{
				foreach ($this as $key => $property)
				{
					if (!empty($a[$key]))
					{
						$this->$key = $a[$key];
					}
				}
			}
		}

		public function getDate()
		{
			$date = new DateTime();
			$date->setTimestamp($this->date);
			return $date->format('H:i d.m.Y');
		}

		public static function getPosts($domain, $count = 3, $offset = 0, $extended = 1, $filter = 'all')
		{
			$g = Other::getPlusMinusId($domain);
			$data = App::api('wall.get', array(
				'owner_id'=> $g,
				'offset'=>$offset,
				'extended'=>$extended,
				'count'=>$count,
				'filter'=>$filter,
			));
			$posts = array();
			foreach ($data['items'] as $key => $post)
			{
				$posts[] = new Post($post);
			}
			return $posts;
		}

		public static function addPost($owner_id, $user_id, $message = '', $attachments = '')
		{
			$g = Other::getPlusMinusId($owner_id);
			$arAttachments = App::upload_photo($g, array($attachments));

			$attachments = array();
			foreach ($arAttachments as $key => $value)
			{
				$attachments[] = 'photo'.$user_id.'_'.$value;
			}
			$data = App::api('wall.post', array(
				'owner_id'=> $g,
				'message'=>$message,
				'attachments'=>$attachments
			));
			return $data['post_id'];
		}
	}