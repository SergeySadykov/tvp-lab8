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
										echo "Фотография";
										echo "<a id = 'content_header_online' href = 'photo.php?action=edit&aid=".$_GET['aid']."&id=".$_GET['id']."'> Изменить описание </a>";
										echo "<a id = 'content_header_online' style = 'padding-right: 10px;' href = 'photo.php?action=move&aid=".$_GET['aid']."&id=".$_GET['id']."'> Переместить </a>";
										echo "<a id = 'content_header_online' style = 'padding-right: 10px;' href = 'photo.php?action=cover&aid=".$_GET['aid']."&id=".$_GET['id']."'> Сделать обложкой </a>";
										break;
									case (edit):
										echo "Изменение описания";
										echo "<a id = 'content_header_online' href = 'photo.php?action=view&aid=".$_GET['aid']."&id=".$_GET['id']."'> Назад </a>";
										break;
									case (move):
										echo "Перемещение в другой альбом";
										echo "<a id = 'content_header_online' href = 'photo.php?action=view&aid=".$_GET['aid']."&id=".$_GET['id']."'> Назад </a>";
										break;
									case (cover):	
										echo "Задание обложной альбома";
										echo "<a id = 'content_header_online' href = 'photo.php?action=view&aid=".$_GET['aid']."&id=".$_GET['id']."'> Назад </a>";
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
									$photo = Photos::getById(UID, $_GET['id'], 1);
									if (!$photo->photo_604)
									{
										echo "<img style = 'width: 100%; margin-bottom: 6px;' src = '".$photo->photo_807."'>";
									}
									else
									{
										echo "<img style = 'width: 100%; margin-bottom: 6px;' src = '".$photo->photo_604."'>";
									}
									echo "<h1 id = 'content_header_name'> Likes: ".$photo->likes['count']." Comments: ".$photo->comments['count']."</h1>";
									echo "<div id = 'hr'></div>";
									echo "<h1 id = 'content_header_name'> Capition: ".$photo->text."</h1>";
									break;
								case (cover):
									$result = Photos::makeCover(UID, $_GET['id'], $_GET['aid']);
									echo "<h1 id = 'content_header_name'>".$result."</h1>";
									break;
								case (edit):
									$photo = Photos::getById(UID, $_GET['id'], 1);
									if (empty($_POST))
									{
										?>
										<form enctype="multipart/form-data" action="photo.php?action=edit&aid=<?=$_GET['aid']?>&id=<?=$_GET['id']?>" method="post">
											<div id = "content_2_row">
												<div id = "content_2_row_name"> Описание: </div>
												<textarea id = "width_200" name="description"><?=$photo->text?></textarea>
											</div>
											<input id = "button15" type="submit" value="Изменить"/>
										</form>
										<?
									}
									else
									{
										echo "<h1 id = 'content_header_name'>".Photos::edit(UID, $_GET['id'], $_POST['description'])."</h1>";
									}
									break;
								case (move):
									
										if (empty($_POST))
										{
										?>
											<form enctype="multipart/form-data" action="photo.php?action=move&aid=<?=$_GET['aid']?>&id=<?=$_GET['id']?>" method="post">
												<div id = "content_2_row">
													<div id = "content_2_row_name" style = "margin-top: 2px;"> Выберите альбом: </div>
													<select name = "album">
														<option disabled >Альбомов нет</option>
														<?
															$albums = Albums::getAlbums(UID, 0);
															foreach ($albums as $value)
															{
																echo "<option value = '".$value->id."'>".$value->title."</option>";
															}
														?>
													</select>
													<input id = "button15" type="submit" value="Переместить"/>
												</div>
												
											</form>
										<?
										}
										else
										{
											echo Photos::move(UID, $_POST['album'], $_GET['id']);
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