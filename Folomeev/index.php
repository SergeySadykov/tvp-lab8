<!DOCTYPE>
<html>
	<head>
		<link href = "css/styles.css" rel = "stylesheet" type = "text/css">
		<?
			require_once('classes/App.php');
			require_once('classes/User.php');
			require_once('classes/Photos.php');
			
			define('UID', 111868333);
			
			$user = User::getUser(UID);
			
			//mpr($user);	
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
							<?=$user->first_name?> <?=$user->last_name?> 
							<b id = "content_header_online"> <?=($user->online == 1) ? 'Online' : ''?> </b>
						</h1>
					</div>
					<div class = "content_2">
						<div id = "content_2_profile"> 
							<img src = "<?=$user->photo_200_orig?>">
						</div>
						<div id = "content_2_info">
							<div id = "content_2_info_block">
								<div id = "content_2_name">
									<?=$user->first_name?> <?=$user->last_name?>
								</div>
								<div id = "content_2_status">
									<?=$user->status?>
								</div>
							</div>
							<div id = "hr"></div>
							<div id = "content_2_info_block">
								<div id = "content_2_row">
									<div id = "content_2_row_name">
										Место учебы:
									</div>
									<div id = "content_2_row_text">
										<?=$user->universities[0]['name']?>
									</div>
									<div class = "clear"></div>
								</div>
								<div id = "content_2_row">
									<div id = "content_2_row_name">
										Факультет:
									</div>
									<div id = "content_2_row_text">
										<?=$user->universities[0]['faculty_name']?>
									</div>
									<div class = "clear"></div>
								</div>
								<div id = "content_2_row">
									<div id = "content_2_row_name">
										Кафедра:
									</div>
									<div id = "content_2_row_text">
										<?=$user->universities[0]['chair_name']?>
									</div>
									<div class = "clear"></div>
								</div>
							</div>
						</div>
						<div class = "clear"></div>
					</div>
				</div>
				<div class = "clear"></div>
			</div>
		</div>
	</body>
</html>