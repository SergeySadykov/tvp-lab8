<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INDA TVPLAB</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?
		require_once('parses/Api.php');
		require_once('parses/App.php');
		require_once('parses/User.php');
		require_once('parses/Post.php');
		require_once('parses/Comment.php');
		require_once('parses/Group.php');
		
		define('UID', 27493985);
		$uposts = Api::getPosts(UID, 9);
		
		
		$user = Api::getUser(UID);
		//mpr($user);
?>
	<header>
		<section class="container">
			INDA TVP
		</section>
	</header>
	<section class="container wrapper">
		<aside class="aside-left">
			<figure>
				<img src="<?=$user->photo_200?>" alt="">
			</figure>
			<div id="friends">
				Тут друзья
				<?
					$friends = User::getFriends(UID);
					foreach($friends as $key => $friend)
					{?>
						<div class="friends">
							<img src="<?=$friend['photo_50']?>" >
							<div class="fbody">
								<?=$friend['first_name']?> <?=$friend['last_name']?>	
							</div>
						</div>
					<?}
				?>
			</div>
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
<hr>
			<section class="wall">
				<div class="post-add">
					<form action="/" method="post">
						<textarea id="post_text" name="post_text" cols="20" rows="20"></textarea>
						<div class="clear"></div>
						<button class="krasivo" name="post_image">
							<!--tut budet picture-->
							Прикрепить
						</button>
						<input id="post_group_id" type="hidden" name="post_group_id" value="<?=UID?>">
						<input id="post_user_id" type="hidden" name="post_user_id" value="<?=UID?>">
						
						<input class="krasivo" type="submit" name="post_btn" value="Отправить">
						<br>
					</form>
					<br>
					
				</div>
				<div class="clear"></div>
				<h4>Брат Братан Братишка</h4>
				<?foreach ($uposts as $key => $post)
				{?>
					<? $author = Api::getUser($post->from_id); ?>
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
					<? $comments = Api::getComments($post->owner_id, $post->id, 10) ?>
					<? if(count($comments) > 0) {?>
						<?foreach ($comments as $key2 => $comment)
						{?>
							<?php $c_author = Api::getUser($comment->from_id);	?>
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

			
		</aside>
		<div class="clear"></div>
	</section>

	<script src="jquery.min.js" type="text/javascript"></script>
	<script src="custom.js" type="text/javascript"></script>
</body>
</html>