<?
	class Albums
	{
		public $id;  						// - ������������� �������;
		public $thumb_id; 					// � ������������� ����������, ������� �������� �������� (0, ���� ������� �����������);
		public $owner_id; 					// � ������������� ��������� �������;
		public $title; 						// � �������� �������;
		public $description; 				// � �������� �������; (�� �������� ��� ��������� ��������)
		public $created; 					// � ���� �������� ������� � ������� unixtime; (�� �������� ��� ��������� ��������);
		public $updated; 					// � ���� ���������� ���������� ������� � ������� unixtime; (�� �������� ��� ��������� ��������);
		public $size; 						// � ���������� ���������� � �������;
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
		
		public static function getAlbums($owner_id, $need_system) // ��������� ������ �������� �� id ������������, $owner - id user, $need_system - view system albums
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
		public $id;			//������������� ����������. ������������� �����
		public $album_id;	//������������� �������, � ������� ��������� ����������. int (�������� ��������)
		public $owner_id;	//������������� ��������� ����������. int (�������� ��������)
		public $user_id;	//������������� ������������, ������������ ���� (���� ���������� ��������� � ����������). ��� ����������, ����������� �� ����� ����������, user_id=100. ������������� �����
		public $photo_75;	//url ����� ���������� � ������������ �������� 75x75px. ������
		public $photo_130;	//url ����� ���������� � ������������ �������� 130x130px. ������
		public $photo_604;	//url ����� ���������� � ������������ �������� 604x604px. ������
		public $photo_807;	//url ����� ���������� � ������������ �������� 807x807px. ������
		public $photo_1280;	//url ����� ���������� � ������������ �������� 1280x1024px. ������
		public $photo_2560;	//url ����� ���������� � ������������ �������� 2560x2048px. ������
		public $width;		//������ ��������� ���������� � ��������. ������������� �����
		public $height;		//������ ��������� ���������� � ��������. ������������� �����
		public $text;		//����� �������� ����������. ������
		public $date;		//���� ���������� � ������� unixtime. ������������� �����
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
		
		public static function get($owner_id, $album_id, $extended, $rev) // ��������� ���������� �� ���������� �������
		{
			$data = Api::api_call('photos.get', array ( 'owner_id' => $owner_id, 'album_id' => $album_id, 'extended' => $extended, 'rev' => $rev)); // Decode_JSON
			$data_parse = array();
			for ($i = 0; $i < $data['count']; $i++)
			{
				$data_parse[$i] = new Photos($data['items'][$i]);
			}
			return $data_parse;
		}
		
		public static function makeCover($owner_id, $photo_id, $album_id) // ������������ ���������� �������� �������
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
		
		public static function getById($owner_id, $photos, $extended) // ��������� ���������� �� ��������� ����������
		{
			$photo = $owner_id.'_'.$photos;
			$data = Api::api_call('photos.getById', array ( 'photos' => $photo, 'extended' => $extended ));
			return new Photos($data[0]);
		}
		
		public static function move($owner_id, $target_album_id, $photo_id) // ����������� ���������� �� ������ ������� � ������
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
		
		public static function edit($owner_id, $photo_id, $caption) // ��������� �������� ����������
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