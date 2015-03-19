<!DOCTYPE>
<html>
	<head>
		<link href = "css/styles.css" rel = "stylesheet" type = "text/css">
		<?
			require_once('classes/App.php');
			require_once('classes/User.php');
			require_once('classes/Photos.php');
			
			define('UID', 111868333);
			
			
		?>
	</head>
	<body>
		<div class = "shell">
			<header>
				<div id = "header_logo">
					Вконтакте
				</div>
			</header>
			<div class = "container">
				<div class = "menu">
					<div id = "menu_block">
						<a href = "index.php" id = "menu_href"> Моя Страница </a>
					</div>
					<div id = "menu_block">
						<a href = "albums.php" id = "menu_href"> Мои Фотографии </a>
					</div>
					<div id = "hr"></div>
				</div>
				<div class = "content">
					<div class = "content_header">
						<h1 id = "content_header_name"> 
						<?
							switch ($_GET['action'])
								{
									default:
									case (view):
										echo "Альбом";
										echo "<a id = 'content_header_online' href = 'album.php?action=add&id=".$_GET['id']."'> Добавить фотографию </a>";
										break;
									case (add):
										echo "Добавление фотографии";
										echo "<a id = 'content_header_online' href = 'album.php?action=view&id=".$_GET['id']."'> Назад </a>";
										break;
								}
						?>
						</h1>
					</div>
					<div class = "content_2">
						<?
							switch ($_GET['action'])
							{
								default:
								case (view):
									$photos = Photos::get(UID, $_GET['id'], 1, 1);
									foreach ($photos as $key => $value)
									{
										echo "<div id = 'content_2_row_album_shell' >";
											echo "<div id = 'content_2_row_album' >";
												echo "<a href = 'photo.php?aid=".$_GET['id']."&id=".$value->id."'>";
													echo "<img id = 'content_2_row_img' src = '".$value->photo_604."'>";
												echo "</a>";
											echo "</div>";
											echo "<div id = 'content_2_row_namea'> Likes: ".$value->likes['count']." Comments: ".$value->comments['count']."</div>";
										echo "</div>";
									}
									break;
								case (add):
									if (empty($_FILES))
									{
										?>
										<form enctype="multipart/form-data" action="album.php?action=add&id=<?=$_GET['id']?>" method="post">
											<input id = "button15" type="file" name="photo"/>
											<input id = "button15" type="submit" value="Загрузить"/>
										</form>
										<?
									}
									else
									{
										$result = Photos::uploadPhoto($_GET['id'], $_FILES);
										if (!$result['error'])
										{
											echo "<h1 id = 'content_header_name'> Фотография успешно добавлена. </h1>";
										}
										else
										{
											echo "<h1 id = 'content_header_name'> При добавлении фотографии произошла ошибка. </h1>";
										}
									}
									break;
							}
						?>
					</div>
				</div>
				<div class = "clear"></div>
			</div>
		</div>
	</body>
</html>