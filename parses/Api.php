<?php

class Api{

	/* =================== USER ================== */
	public static function getUser($id_user)
	{
		$data = App::api('users.get', array(
			'user_ids'=> $id_user,
			'fields'=> 'sex, bdate, city, country, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, photo_id, online, online_mobile, domain, has_mobile, contacts, connections, site, education, universities, schools, can_post, can_see_all_posts, can_see_audio, can_write_private_message, status, last_seen, common_count, relation, relatives, counters, screen_name, maiden_name, timezone, occupation,activities, interests, music, movies, tv, books, games, about, quotes, personal, friends_status'
		));
		return new User($data[0]);
	}

	public static function getUserAdminGroupsName($id_user, $count = 10, $offset = 0)
	{
		$data = App::api('groups.get', array(
			'user_id'=> intval($id_user),
			'offset'=>$offset,
			'extended'=>'1',
			'count'=>$count,
			'fields'=> 'city, country, place, description, wiki_page, members_count, counters, start_date, finish_date, can_post, can_see_all_posts, activity, status, contacts, links, fixed_post, verified, site, can_create_topic'
		));
		$adminGroups = array();
		foreach ($data['items'] as $key => $group)
		{
			if ($group['is_admin'] == 1 && $group['admin_level'] == 3)
			{
				$adminGroups[] = $group['name'];
			}
		}
		return $adminGroups;
	}

	/* =================== GROUP ================== */
	public static function getGroup($group_id)
	{
		$data = App::api('groups.getById', array(
			'group_id'=> $group_id,
		));
		$group = new Group($data[0]);
		return $group;
	}

	/* =================== POST ================== */
	public static function getPosts($domain, $count = 3, $offset = 0, $extended = 1)
	{
		$g = self::getPlusMinusId($domain);
		$data = App::api('wall.get', array(
			'owner_id'=> $g,
			'offset'=>$offset,
			'extended'=>$extended,
			'count'=>$count,
			'filter'=>'all',
		));
		$posts = array();
		foreach ($data['items'] as $key => $post)
		{
			$posts[] = new Post($post);
		}
		return $posts;
	}

	public static function addPost($owner_id, $user_id, $message = '', $attachments = '')
	{
		$g = self::getPlusMinusId($owner_id);
		$arAttachments = App::upload_photo($g, array($attachments));

		$attachments = array();
		foreach ($arAttachments as $key => $value)
		{
			$attachments[] = 'photo'.$user_id.'_'.$value;
		}
		$data = App::api('wall.post', array(
			'owner_id'=> $g,
			'message'=>$message,
			'attachments'=>$attachments
		));
		return $data['post_id'];
	}

	/* =================== COMMENT ================== */
	public static function getComments($domain, $post_id, $count = 3, $offset = 0)
	{
		$g = self::getPlusMinusId($domain);
		$data = App::api('wall.getComments', array(
			'owner_id'=> $g,
			'post_id'=>$post_id,
			'offset'=>$offset,
			'count'=>$count,
		));
		if (!isset($data['error']))
		{
			$comments = array();
			foreach ($data['items'] as $key => $comment)
			{
				$comments[] = new Comment($comment);
			}
			return $comments;
		}
	}

	public static function addComment($owner_id, $post_id, $text, $attachments)
	{
		$g = self::getPlusMinusId($owner_id);
		$data = App::api('wall.addComment', array(
			'owner_id'=> $g,
			'post_id'=>$post_id,
			'text'=>$text,
			'attachments'=>$attachments,
		));
		return $data['comment_id'];
	}

	/* =================== MESSAGE ================== */
	public static function getMessages($count = 20)
	{
		$data = App::api('messages.get', array(
			'count'=> $count,
		));
		return $data;
	}

	/* =================== OTHER ================== */
	public static function getPlusMinusId($id)
	{
		$iId = intval($id);
		if ($iId != 0)
			$g = $id;
		else
		{
			if (substr($id, 0, 1) == '-')
			{
				$id = substr($id, 1);
				$group = self::getGroup($id);
				$g = '-'.$group->id;
			}
			else
			{
				$user = self::getUser($id);
				$g = $user->id;
			}
		}
		return $g;
	}

}