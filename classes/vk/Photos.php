<?
	class Albums
	{
		public $id;  						// - идентификатор альбома;
		public $thumb_id; 					// — идентификатор фотографии, которая является обложкой (0, если обложка отсутствует);
		public $owner_id; 					// — идентификатор владельца альбома;
		public $title; 						// — название альбома;
		public $description; 				// — описание альбома; (не приходит для системных альбомов)
		public $created; 					// — дата создания альбома в формате unixtime; (не приходит для системных альбомов);
		public $updated; 					// — дата последнего обновления альбома в формате unixtime; (не приходит для системных альбомов);
		public $size; 						// — количество фотографий в альбоме;
		public $privacy_view = array();
		public $privacy_comment = array();
		public $photo_75;
		public $photo_130;
		public $photo_604;
		public $photo_807;
		public $photo_1280;
		public $photo_2560;
		
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
		
		public static function getAlbums($owner_id, $need_system) // Џолучение списка альбомов по id пользователЯ, $owner - id user, $need_system - view system albums
		{
			$data = Api::api_call('photos.getAlbums', array ( 'owner_id' => $owner_id, 'need_system' => $need_system));
			$data_parse = array();
			for ($i = 0; $i < $data['count']; $i++)
			{
				if ($data['items'][$i]['thumb_id'] == 0)
				{
					$data['items'][$i]['photo_604'] = "http://vk.com/images/camera_400.gif";
				}
				else
				{
					$data_2 = Photos::get($owner_id, $data['items'][$i]['id'], 0);
					foreach ($data_2 as $value)
					{
						if ($data['items'][$i]['thumb_id'] == $value->id)
						{
							$data['items'][$i]['photo_75'] = $value->photo_75;
							$data['items'][$i]['photo_130'] = $value->photo_130;
							$data['items'][$i]['photo_604'] = $value->photo_604;
							$data['items'][$i]['photo_1280'] = $value->photo_1280;
							$data['items'][$i]['photo_2560'] = $value->photo_2560;
							break;
						}
					}
				}
				$data_parse[$i] = new Albums($data['items'][$i]);
			}
			return $data_parse;
		}
	}
	
	class Photos
	{
		public $id;			//идентификатор фотографии. положительное число
		public $album_id;	//идентификатор альбома, в котором находитсЯ фотографиЯ. int (числовое значение)
		public $owner_id;	//идентификатор владельца фотографии. int (числовое значение)
		public $user_id;	//идентификатор пользователЯ, загрузившего фото (если фотографиЯ размещена в сообществе). „лЯ фотографий, размещенных от имени сообщества, user_id=100. положительное число
		public $photo_75;	//url копии фотографии с максимальным размером 75x75px. строка
		public $photo_130;	//url копии фотографии с максимальным размером 130x130px. строка
		public $photo_604;	//url копии фотографии с максимальным размером 604x604px. строка
		public $photo_807;	//url копии фотографии с максимальным размером 807x807px. строка
		public $photo_1280;	//url копии фотографии с максимальным размером 1280x1024px. строка
		public $photo_2560;	//url копии фотографии с максимальным размером 2560x2048px. строка
		public $width;		//ширина оригинала фотографии в пикселах. положительное число
		public $height;		//высота оригинала фотографии в пикселах. положительное число
		public $text;		//текст описаниЯ фотографии. строка
		public $date;		//дата добавлениЯ в формате unixtime. положительное число
		public $likes = array();
		public $comments = array();
		public $tags = array();
		
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
		
		public static function get($owner_id, $album_id, $extended, $rev) // Џолучение фотографий из указанного альбома
		{
			$data = Api::api_call('photos.get', array ( 'owner_id' => $owner_id, 'album_id' => $album_id, 'extended' => $extended, 'rev' => $rev)); // Decode_JSON
			$data_parse = array();
			for ($i = 0; $i < $data['count']; $i++)
			{
				$data_parse[$i] = new Photos($data['items'][$i]);
			}
			return $data_parse;
		}
		
		public static function makeCover($owner_id, $photo_id, $album_id) // “становление фотографии обложкой альбома
		{
			$result = Api::api_call('photos.makeCover', array( 'owner_id' => $owner_id, 'photo_id' => $photo_id, 'album_id' => $album_id ));
			if ($result[0] == 1)
			{
				return "Succesful";
			}
			else
			{
				if ($album_id < 0)
				{
					return "$album_id is system album, error.";
				}
				else
				{
					return "Error";
				}
			}
		}
		
		public static function getById($owner_id, $photos, $extended) // Џолучение информации по отдельной фотографии
		{
			$photo = $owner_id.'_'.$photos;
			$data = Api::api_call('photos.getById', array ( 'photos' => $photo, 'extended' => $extended ));
			return new Photos($data[0]);
		}
		
		public static function move($owner_id, $target_album_id, $photo_id) // Џеремещение фотографии из одного альбома в другой
		{
			$result = Api::api_call('photos.move', array ( 'owner_id' => $owner_id, 'target_album_id' => $target_album_id, 'photo_id' => $photo_id));
			mpr($result);
			if ($result[0] == 1)
			{
				return "Succesful";
			}
			else
			{
				if ($target_album_id < 0)
				{
					return "$album_id is system album, error.";
				}
				else
				{
					return "Error";
				}
			}
		}
		
		public static function edit($owner_id, $photo_id, $caption) // €зменение описаниЯ фотографии
		{
			$result = Api::api_call('photos.edit', array ( 'owner_id' => $owner_id, 'photo_id' => $photo_id, 'caption' => $caption ));
			if ($result == 1)
			{
				return "Succesful";
			}
			else
			{
				return "Error";
			}
		}
	}
?>