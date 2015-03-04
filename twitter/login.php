<?
	session_start();
	$_SESSION['target'] = $_POST['target'];
	header('Location: user.php');
?>