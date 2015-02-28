<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Twp8</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<?php
		require_once('../parses/App.php');
		require_once('../parses/User.php');
		require_once('../parses/Post.php');
		require_once('../parses/Comment.php');
		require_once('../parses/Group.php');
		require_once('../parses/Format.php');

		define('UID', 261061018);
		define('GID', 'twplab');

		$uposts = User::getPosts(UID, 3);
		$gposts = Group::getPosts(GID, 1);
		$user = User::getUser(UID);
	?>

	<header>
		<section class="container">
			Вконтакте
		</section>
	</header>
	<section class="container wrapper">
		<aside class="aside-left">
			<figure>
				<img src="<?=$user->photo_200?>" alt="">
			</figure>
		</aside>
		<aside class="aside-right">
			<section class="info">
				<h3><?=$user->first_name?> <?=$user->last_name?>
					<span class="right"><?=( ($user->online == 1 ? 'Online' : '') )?></span>
				</h3>
				<div class="user-info">
					<p>Страна: <?=$user->country['title']?></p>
					<p>Город: <?=$user->city['title']?></p>
				</div>
			</section>
			<hr>
			<section class="wall">
				<h4>Стена пользователя</h4>
				<?foreach ($uposts as $key => $post)
				{?>
					<? $author = User::getUser($post->from_id); ?>
					<article class="post">

						<div class="post-photo">
							<img src="<?=$author->photo_50?>" alt="">
							<figcaption>
								<?=( ($author->online == 1 ? 'Online' : '') )?>
							</figcaption>
						</div>

						<div class="post-body">
							<div class="post-author">
								<?=$author->first_name?> <?=$author->last_name?>
							</div>
							<div class="post-text">
								<?=$post->text?>
							</div>
							<?if(!empty($post->attachments))
							{
								foreach ($post->attachments as $key => $file)
								{?>
									<? if($file['type'] == 'sticker')
											$photo = 'photo_128';
										else
											$photo = 'photo_604';
									?>
									<img src="<?=$file[$file['type']][$photo]?>" alt="">
								<?}
							}?>
							<div class="date"><?=$post->getDate()?></div>
						</div>

						<div class="clear"></div>

					</article>
					<? $comments = User::getComments($post->owner_id, $post->id, 10) ?>
					<? if(count($comments) > 0) {?>
						<?foreach ($comments as $key2 => $comment)
						{?>
							<?php $c_author = User::getUser($comment->from_id);	?>
							<article class="comment">

								<div class="post-photo">
									<img src="<?=$c_author->photo_50?>" alt="">
								</div>

								<div class="post-body">
									<div class="post-author">
										<?=$c_author->first_name?> <?=$c_author->last_name?>
									</div>
									<div class="post-text">
										<?=$comment->text?>
									</div>
									<?if(!empty($comment->attachments))
									{
										foreach ($comment->attachments as $key => $file)
										{?>
											<? if($file['type'] == 'sticker')
													$photo = 'photo_128';
												else
													$photo = 'photo_604';
											?>
											<img src="<?=$file[$file['type']][$photo]?>" alt="">
										<?}
									}?>

									<div class="date"><?=$comment->getDate()?></div>
								</div>

								<div class="clear"></div>

							</article>
						<?}?>
					<?}?>
				<?}?>

			</section>

			<hr>

			<section class="wall">

				<h4>Стена группы</h4>
				<?foreach ($gposts as $key => $post)
				{?>
					<?php
						$check = false;
						if (intval($post->from_id)>0)
						{
							$author = User::getUser($post->from_id);
							$check = true;
						}
						else
							$author = Group::getGroup(substr($post->owner_id, 1));
					?>
					<article class="post">

						<div class="post-photo">
							<img src="<?=$author->photo_50?>" alt="">
						</div>

						<div class="post-body">
							<div class="post-author">
								<?if($check == true){?>
									<?=$author->first_name?> <?=$author->last_name?>
								<?}else{?>
									<?=$author->name?>
								<?}?>
							</div>
							<div class="post-text">
								<?=$post->text?>
							</div>
							<?if(!empty($post->attachments))
							{
								foreach ($post->attachments as $key => $file)
								{?>
									<? if($file['type'] == 'sticker')
											$photo = 'photo_128';
										elseif($file['type'] == 'link')
											$photo = 'image_src';
										else
											$photo = 'photo_604';
									?>
									<img src="<?=$file[$file['type']][$photo]?>" alt="">
								<?}
							}?>
							<div class="date"><?=$post->getDate()?></div>
						</div>

						<div class="clear"></div>

					</article>
					<? $comments = Group::getComments(substr($post->owner_id, 1), $post->id, 10) ?>
					<? if(count($comments) > 0) {?>
						<?foreach ($comments as $key2 => $comment)
						{?>
							<?php $c_author = User::getUser($comment->from_id);	?>
							<article class="comment">

								<div class="post-photo">
									<img src="<?=$c_author->photo_50?>" alt="">
								</div>

								<div class="post-body">
									<div class="post-author">
										<?=$c_author->first_name?> <?=$c_author->last_name?>
									</div>
									<div class="post-text">
										<?=$comment->text?>
									</div>
									<?if(!empty($comment->attachments))
									{
										foreach ($comment->attachments as $key => $file)
										{?>
											<? if($file['type'] == 'sticker')
													$photo = 'photo_128';
												else
													$photo = 'photo_604';
											?>
											<img src="<?=$file[$file['type']][$photo]?>" alt="">
										<?}
									}?>
									<div class="date"><?=$comment->getDate()?></div>
								</div>

								<div class="clear"></div>

							</article>
						<?}?>
					<?}?>
				<?}?>
				<div class="post-add">
					<form action="/" method="post">
						<textarea id="post_text" name="post_text" cols="30" rows="10" placeholder="Текст"></textarea>
						<input id="post_link" type="text" name="post_link" placeholder="Ссылка">
						<select id="post_image" name="post_image">
							<option value=""></option>
							<?
								$max_folder = '../examples/';
								$max_scan = scandir($max_folder);
								for($i = 0; $i < count($max_scan); $i++)
								{
									if(preg_match('/.jpg/', $max_scan[$i]))
									{?>
							        	<option value="<?=$max_scan[$i]?>"><?=$max_scan[$i]?></option>
									<?}
								}
							?>
						</select>
						<input id="post_group_id" type="hidden" name="post_group_id" value="<?=GID?>">
						<input id="post_user_id" type="hidden" name="post_user_id" value="<?=UID?>">
						<input id="post_btn" type="submit" name="post_btn" value="Отправить">
					</form>
				</div>

			</section>
		</aside>
		<div class="clear"></div>
	</section>

	<script src="jquery.min.js" type="text/javascript"></script>
	<script src="custom.js" type="text/javascript"></script>
</body>
</html>