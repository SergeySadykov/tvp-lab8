<?
	class Albums
	{
		public $id;  						// - èäåíòèôèêàòîð àëüáîìà;
		public $thumb_id; 					// — èäåíòèôèêàòîð ôîòîãðàôèè, êîòîðàÿ ÿâëÿåòñÿ îáëîæêîé (0, åñëè îáëîæêà îòñóòñòâóåò);
		public $owner_id; 					// — èäåíòèôèêàòîð âëàäåëüöà àëüáîìà;
		public $title; 						// — íàçâàíèå àëüáîìà;
		public $description; 				// — îïèñàíèå àëüáîìà; (íå ïðèõîäèò äëÿ ñèñòåìíûõ àëüáîìîâ)
		public $created; 					// — äàòà ñîçäàíèÿ àëüáîìà â ôîðìàòå unixtime; (íå ïðèõîäèò äëÿ ñèñòåìíûõ àëüáîìîâ);
		public $updated; 					// — äàòà ïîñëåäíåãî îáíîâëåíèÿ àëüáîìà â ôîðìàòå unixtime; (íå ïðèõîäèò äëÿ ñèñòåìíûõ àëüáîìîâ);
		public $size; 						// — êîëè÷åñòâî ôîòîãðàôèé â àëüáîìå;
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
		
		public static function getAlbums($owner_id, $need_system) // îëó÷åíèå ñïèñêà àëüáîìîâ ïî id ïîëüçîâàòåëß, $owner - id user, $need_system - view system albums
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
							$data['items'][$i]['photo_130'] = $value->photo_130;
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
		
		
		public static function createAlbum($title, $group_id, $description, $privacy, $commennt_privacy, $upload_by_admins_only, $comments_disabled){
			$data = Api::api_call('photos.createAlbum', array ( 'title' => $title, 'group_id' => $group_id, 'description' => $description, 'privacy' => $privacy, 'comment_privacy' => $comment_privacy, 'upload_by_admins_only' => $upload_by_admins_only, 'comments_disabled' => $comments_disabled));
			return new Albums($data[0]);
		}
		
		public static function editAlbum($album_id, $title, $description, $owner_id, $privacy, $commennt_privacy, $upload_by_admins_only, $comments_disabled){
			$result = Api::api_call('photos.editAlbum', array ( 'album_id' => $album_id, 'title' => $title, 'description' => $description, 'owner_id' => $owner_id, 'privacy' => $privacy, 'comment_privacy' => $comment_privacy, 'upload_by_admins_only' => $upload_by_admins_only, 'comments_disabled' => $comments_disabled));
			if ($result[0] == 1) {
				return "Successful";
			} else {
				if ($album_id < 0) {
					return "$album_id is a system album, error.";
				} else {
					return "Error";
				}
			}
		}
		
		public static function deleteAlbum($album_id, $group_id) {
			$result = Api::api_call('photos.deleteAlbum', array ( 'album_id' => $album_id, 'group_id' => $group_id ));
			if ($result[0] == 1) {
				return "Successful";
			} else {
				if ($album_id < 0) {
					return "$album_id is a system album, error.";
				} else {
					return "Error";
				}
			}
		}
		
		public static function reorderAlbums($owner_id, $album_id, $before, $after){
			$result = Api::api_call('photos.reorderAlbums', array ( 'owner_id' => $owner_id, 'album_id' => $album_id, 'before' => $before, 'after' => $after ));
			if ($result[0] == 1) { 
				return "Successful";
			} else { 
				return "Error";
			}
		}
	}
	
	class Photos
	{
		public $id;			//èäåíòèôèêàòîð ôîòîãðàôèè. ïîëîæèòåëüíîå ÷èñëî
		public $album_id;	//èäåíòèôèêàòîð àëüáîìà, â êîòîðîì íàõîäèòñß ôîòîãðàôèß. int (÷èñëîâîå çíà÷åíèå)
		public $owner_id;	//èäåíòèôèêàòîð âëàäåëüöà ôîòîãðàôèè. int (÷èñëîâîå çíà÷åíèå)
		public $user_id;	//èäåíòèôèêàòîð ïîëüçîâàòåëß, çàãðóçèâøåãî ôîòî (åñëè ôîòîãðàôèß ðàçìåùåíà â ñîîáùåñòâå). „ëß ôîòîãðàôèé, ðàçìåùåííûõ îò èìåíè ñîîáùåñòâà, user_id=100. ïîëîæèòåëüíîå ÷èñëî
		public $photo_75;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 75x75px. ñòðîêà
		public $photo_130;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 130x130px. ñòðîêà
		public $photo_604;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 604x604px. ñòðîêà
		public $photo_807;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 807x807px. ñòðîêà
		public $photo_1280;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 1280x1024px. ñòðîêà
		public $photo_2560;	//url êîïèè ôîòîãðàôèè ñ ìàêñèìàëüíûì ðàçìåðîì 2560x2048px. ñòðîêà
		public $width;		//øèðèíà îðèãèíàëà ôîòîãðàôèè â ïèêñåëàõ. ïîëîæèòåëüíîå ÷èñëî
		public $height;		//âûñîòà îðèãèíàëà ôîòîãðàôèè â ïèêñåëàõ. ïîëîæèòåëüíîå ÷èñëî
		public $text;		//òåêñò îïèñàíèß ôîòîãðàôèè. ñòðîêà
		public $date;		//äàòà äîáàâëåíèß â ôîðìàòå unixtime. ïîëîæèòåëüíîå ÷èñëî
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
		
		public static function get($owner_id, $album_id, $extended, $rev) // îëó÷åíèå ôîòîãðàôèé èç óêàçàííîãî àëüáîìà
		{
			$data = Api::api_call('photos.get', array ( 'owner_id' => $owner_id, 'album_id' => $album_id, 'extended' => $extended, 'rev' => $rev)); // Decode_JSON
			$data_parse = array();
			for ($i = 0; $i < $data['count']; $i++)
			{
				$data_parse[$i] = new Photos($data['items'][$i]);
			}
			return $data_parse;
		}
		
		public static function makeCover($owner_id, $photo_id, $album_id) // “ñòàíîâëåíèå ôîòîãðàôèè îáëîæêîé àëüáîìà
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
		
		public static function getById($owner_id, $photos, $extended) // îëó÷åíèå èíôîðìàöèè ïî îòäåëüíîé ôîòîãðàôèè
		{
			$photo = $owner_id.'_'.$photos;
			$data = Api::api_call('photos.getById', array ( 'photos' => $photo, 'extended' => $extended ));
			return new Photos($data[0]);
		}
		
		public static function move($owner_id, $target_album_id, $photo_id) // åðåìåùåíèå ôîòîãðàôèè èç îäíîãî àëüáîìà â äðóãîé
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
		
		public static function edit($owner_id, $photo_id, $caption) // ˆçìåíåíèå îïèñàíèß ôîòîãðàôèè
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
