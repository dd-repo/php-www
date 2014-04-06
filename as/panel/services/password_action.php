<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
		throw new Exception("Password mismatch");
	
	$params = array();
	$params['pass'] = $_POST['pass'];
	$params['service'] = $_POST['service'];

	api::send('self/service/update', $params);

	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
}
catch(Exception $e)
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/services/config?service=' . security::encode($_POST['service']));

?>
