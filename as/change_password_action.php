<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
	throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");

$params = array();
$params['pass'] = $_POST['pass'];
		
api::send('self/update', $params, $_POST['user'] . ':' . $_POST['token']);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];
			
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/change_password');

?>