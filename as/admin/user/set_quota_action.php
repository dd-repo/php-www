<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('quota/user/update', array('user'=>$_GET['user'], 'quota'=>$_GET['quota'], 'max'=>$_GET['max'], 'used'=>$_GET['used']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id='.$_GET['user']);

?>