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
	}