<?php
	class Group{

		public $id;
		public $name;
		public $screen_name;
		public $is_closed;
		public $deactivated;
		public $is_admin;
		public $admin_level;
		public $is_member;
		public $type;
		public $photo_50;
		public $photo_100;
		public $photo_200;
		public $ban_info = array();
		public $city;
		public $country;
		public $place = array();
		public $description;
		public $wiki_page;
		public $members_count;
		public $counters;
		public $start_date;
		public $finish_date;
		public $can_post;
		public $can_see_all_posts;
		public $can_upload_doc;
		public $can_upload_video;
		public $can_create_topic;
		public $activity;
		public $status;
		public $contacts;
		public $links;
		public $fixed_post;
		public $verified;
		public $main_album_id;
		public $is_favorite;

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
	}