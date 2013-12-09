<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$result = api::send('self/token/add', array('name'=>$_GET['name']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/token/detail?token='.$result['token']);

?>