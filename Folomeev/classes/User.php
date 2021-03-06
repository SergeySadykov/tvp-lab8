<?php
	class User{

		public $id;
		public $first_name;
		public $last_name;
		public $sex;
		public $domain;
		public $bdate;
		public $screen_name;
		public $maiden_name;
		public $crop_photo;
		public $is_friend;
		public $friend_status;
		public $city = array();
		public $country = array();
		public $timezone;
		public $photo_50;
		public $photo_100;
		public $photo_200;
		public $photo_max;
		public $photo_200_orig;
		public $photo_400_orig;
		public $photo_max_orig;
		public $photo_id;
		public $has_mobile;
		public $online;
		public $can_post;
		public $can_see_all_posts;
		public $can_see_audio;
		public $can_write_private_message;
		public $can_send_friend_request;
		public $is_favorite;
		public $mobile_phone;
		public $home_phone;
		public $home_town;
		public $site;
		public $status;
		public $last_seen = array();
		public $common_count;
		public $followers_count;
		public $counters = array();
		public $university;
		public $university_name;
		public $faculty;
		public $faculty_name;
		public $graduation;
		public $relation;
		public $personal = array();
		public $interests;
		public $music;
		public $activities;
		public $movies;
		public $tv;
		public $books;
		public $games;
		public $universities = array();
		public $schools = array();
		public $about;
		public $relatives = array();
		public $quotes;
		public $education;
		public $contacts;
		public $lists;
		public $blacklisted;
		public $verified;
		public $hidden;
		public $deactivated;
		public $occupation;
		public $nickname;
		public $connections;
		public $exports;
		public $wall_comments;

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
		
		public static function getUser($id_user)
		{
			$data = App::api('users.get', 
				array(	'user_ids'=> $id_user, 
						'fields'=> 'sex, 
									bdate,
									city, 
									country, 
									photo_50, 
									photo_100, 
									photo_200_orig, 
									photo_200, 
									photo_400_orig, 
									photo_max, 
									photo_max_orig, 
									photo_id, 
									online, 
									online_mobile, 
									domain, 
									has_mobile, 
									contacts, 
									connections, 
									site, 
									education, 
									universities, 
									schools, 
									can_post, 
									can_see_all_posts, 
									can_see_audio, 
									can_write_private_message, 
									status, 
									last_seen, 
									common_count, 
									relation, 
									relatives, 
									counters, 
									screen_name, 
									maiden_name, 
									timezone, 
									occupation,
									activities, 
									interests, 
									music, 
									movies, 
									tv, 
									books, 
									games, 
									about, 
									quotes, 
									personal, 
									friends_status'
			));
			return new User($data[0]);
		}
	}