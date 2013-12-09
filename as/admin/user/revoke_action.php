<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('grant/user/revoke', array('user'=>$_GET['user'], 'grant'=>$_GET['grant']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id=' . $_GET['user']);

?>