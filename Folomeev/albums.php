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
										echo "Альбомы";
										echo "<a id = 'content_header_online' href = 'albums.php?action=create'> Создать альбом </a>";
										break;
									case (create):
										echo "Создание альбома";
										echo "<a id = 'content_header_online' href = 'albums.php?action=view'> Назад </a>";
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
								$albums = Albums::getAlbums(UID, 1);
								foreach ($albums as $key => $value)
								{
										echo "<div id = 'content_2_row_album_shell' >";
											echo "<div id = 'content_2_row_album' >";
												echo "<a href = 'album.php?id=".$value->id."'>";
													echo "<img id = 'content_2_row_img' src = '".$value->photo_604."'>";
												echo "</a>";
											echo "</div>";
											echo "<div id = 'content_2_row_namea'>".$value->title."</div>";
										echo "</div>";
								}
								break;
							case (create):
								if (empty($_POST))
								{
									?>
										<form enctype="multipart/form-data" action="albums.php?action=create" method="post">
											<div id = "content_2_row">
												<div id = "content_2_row_name"> Название: </div>
												<input id = "width_200" type="text" name="title"/>
												<input id = "button15" type="submit" value="Создать альбом"/>
											</div>
											<div id = "content_2_row">
												<div id = "content_2_row_name"> Описание: </div>
												<textarea id = "width_200" name="description"></textarea>
											</div>
										</form>
									<?
								}
								else
								{
									$result = Albums::createAlbum($_POST['title'], $_POST['description']);
									if ($result) echo "<h1 id = 'content_header_name'> Альбом '".$result->title."' успешно создан.</h1>";
									else echo "<h1 id = 'content_header_name'> Альбом '".$result->title."' не создан.</h1>";
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