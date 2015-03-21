<?php

	require_once('parses/Api.php');
	require_once('parses/App.php');
	require_once('parses/User.php');
	require_once('parses/Post.php');
	require_once('parses/Comment.php');
	require_once('parses/Group.php');

	$uid = $_POST['uid'];
	$gid = $_POST['gid'];
	$message = $_POST['message'];
	$attachments = $_POST['attachments'];

	$id = Api::addPost($uid, $uid, $message, $attachments);