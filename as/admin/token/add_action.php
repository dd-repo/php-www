<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$result = api::send('token/add', array('name'=>$_GET['name'], 'user'=>$_GET['user']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/token/detail?token='.$result['token'].'&user='.$_GET['user']);

?>