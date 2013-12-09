<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
	
api::send('quota/user/del', array('user'=>$_GET['user'], 'quota'=>$_GET['quota']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id='.$_GET['user']);

?>