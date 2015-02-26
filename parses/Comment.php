<?php
	class Comment{

		public $id;
		public $from_id;
		public $date;
		public $text;
		public $reply_to_user;
		public $reply_to_comment;
		public $attachments = array();

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