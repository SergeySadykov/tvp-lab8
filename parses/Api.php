<?php

class Api{

	public static function getUserInfo($token, $id_user)
	{
		$url = App::METHOD_URL.'users.get?user_id='.$id_user.
				'&fields=sex, bdate, city, country, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, photo_id, online, online_mobile, domain, has_mobile, contacts, connections, site, education, universities, schools, can_post, can_see_all_posts, can_see_audio, can_write_private_message, status, last_seen, common_count, relation, relatives, counters, screen_name, maiden_name, timezone, occupation,activities, interests, music, movies, tv, books, games, about, quotes, personal, friends_status&v='.App::API_VERSION.'&access_token='.$token;
		$arUser = App::call($url)[0];
		return new User($arUser);
	}

	public static function getUserAdminGroupsName($token, $id_user, $offset = 0)
	{
		if ($offset <= 1000)
		{
			$url = App::METHOD_URL.'groups.get?user_id='.$id_user.
					'&offset='.$offset.'&extended=1&fields=city, country, place, description, wiki_page, members_count, counters, start_date, finish_date, can_post, can_see_all_posts, activity, status, contacts, links, fixed_post, verified, site, can_create_topic&offset=0&count=1000&v='.App::API_VERSION.'&access_token='.$token;
			$arGroups = App::call($url);
			$adminGroups = array();
			foreach ($arGroups['items'] as $key => $group)
			{
				if ($group['is_admin'] == 1 && $group['admin_level'] == 3)
				{
					$adminGroups[] = $group['name'];
				}
			}
			return $adminGroups;
		}
		else
		{
			throw new Exception('Смещение должно быть меньше или равно 1000!');
		}
	}

	public static function getGroupTopics($token, $domain, $offset = 0)
	{
		if ($offset <= 100)
		{
			$url = App::METHOD_URL.'wall.get?domain='.$domain.
				'&offset='.$offset.'&count=100&filter=all&v='.App::API_VERSION.'&access_token='.$token;
			$arPosts = App::call($url);
			$posts = array();
			foreach ($arPosts['items'] as $key => $post)
			{
				$posts[] = new Post($post);
			}
			return $posts;
		}
		else
		{
			throw new Exception('Смещение должно быть меньше или равно 100!');
		}
	}

	public static function getGroupTopicComments($token, $domain, $post_id, $offset = 0)
	{
		if ($offset <= 100)
		{
			$url = App::METHOD_URL.'wall.getComments?owner_id=-'.$domain.
				'&post_id='.$post_id.'&offset='.$offset.'&count=100&filter=all&v='.App::API_VERSION.'&access_token='.$token;
			$arComments = App::call($url);
			$comments = array();
			foreach ($arComments['items'] as $key => $comment)
			{
				$comments[] = new Comment($comment);
			}
			return $comments;
		}
		else
		{
			throw new Exception('Смещение должно быть меньше или равно 100!');
		}
	}

}