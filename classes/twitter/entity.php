<?
	/**
	* Entities provide metadata and additional contextual
	* information about content posted on Twitter.
	* Entities are never divorced from the content they describe.
	*/
	

	class Hashtags
	{
		public $indices;
		public $text;
	}
	
	class Entity
	{
		public $hashtags;
		public $media;
		public $urls;
		public $userMentions;
	}

	class Media
	{
		public $displayUrl;
		public $expandedUrl;
		public $id;
		public $idStr;
		public $indices;
		public $mediaUrl;
		public $mediaUrlHttps;
		public $sizes;
		public $sourceStatusId;
		public $sourceStatusIdStr;
		public $type;
		public $url;
	}

	class Size
	{
		public $h;
		public $resize;
		public $w;
	}

	class Sizes
	{
		public $thumb;
		public $large;
		public $medium;
		public $small;
	}

	class Url
	{
		public $displayUrl;
		public $expandedUrl;
		public $indices;
		public $url;
	}

	class UserMention
	{
		public $id;
		public $idStr;
		public $indices;
		public $name;
		public $screenName;
	}
?>