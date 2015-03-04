<?
	session_start();
	if(isset($_SESSION['target']))
	{
		header('Location: user.php');
	}
	else
	{
		header('Location: welcome.php');
	}
?>