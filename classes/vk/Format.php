<?php
	class Format{

		public static function encodeJSON($data)
		{
			return json_encode($data);
		}

		public static function decodeJSON($data)
		{
			return json_decode($data);
		}

		public static function encodeXML($data)
		{
			return xmlrpc_encode($data);
		}

		public static function decodeXML($data)
		{
			return xmlrpc_decode($data);
		}

		public static function encodeFile($data)
		{
			$line = "";
			$i = 0;
			foreach ($data as $key => $property)
			{
				if (gettype($property) == "array" || gettype($property) == 'object')
					$line .= Format::encodeFile($data->$key);
				else
				{
					if (!empty($property))
					{
						$line .= $property;
						if ($i != count((array)$data)-1)
						{
							$line .= ';';
						}
					}
					$i++;
				}
			}
			return '('.$line.');';
		}
	}