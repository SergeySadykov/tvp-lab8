<?php
	class User{

		public $id;
		public $first_name;
		public $last_name;
		public $deactivated;
		public $hidden = 1;

		public $photo_id;
		public $verified;
		public $blacklisted;
		public $sex;
		public $city;
		public $country;
		public $home_town;
		public $photo_50;
		public $photo_100;
		public $photo_200_orig;
		public $photo_200;
		public $photo_400_orig;
		public $photo_400_max;
		public $photo_400_max_orig;
		public $online;
		public $lists;
		public $domain;
		public $has_mobile;
		public $contacts;
		public $site;
		public $education;
		public $universities;
		public $schools;
		public $status;
		public $last_seen;
		public $followers_count;
		public $common_count;
		public $counters;

		public getUserInfo()
		{
			return true;
		}

	}