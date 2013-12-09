<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
	
if( isset($_POST['antispam']) && $_POST['antispam'] == $_SESSION['ANTISPAM'] )
{
	try
	{
		unset($_SESSION['ANTISPAM']);
		$security->login($_POST['username'], $_POST['password'], ($_POST['remember'] == 'remember'));
	}
	catch(Exception $e)
	{
		$template->redirect('/' . $GLOBALS['CONFIG']['LOGIN_PAGE'] . '?e');
	}
}
else
	$template->redirect('/' . $GLOBALS['CONFIG']['LOGIN_PAGE'] . '?e');

?>