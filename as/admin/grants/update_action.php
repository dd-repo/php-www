<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('grant/update', array('id'=>$_POST['id'], 'name'=>$_POST['name']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/grants/detail?id=' . $_POST['id']);

?>