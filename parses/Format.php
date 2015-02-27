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
			foreach ($data as $key => $property)
			{
				if (gettype($property) == "array" || gettype($property) == 'object')
					$line .= User::encodeFile($data->$key);
				else
					if (!empty($property))
						$line .= $property.";";
			}
			return $line;
		}
	}