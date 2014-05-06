<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/app/del', array('id'=>$_GET['id']));
	api::send('self/subdomain/del', array('domain'=>'anotherservice.net', 'subdomain'=>strtolower($_GET['name'])));
}
catch(Exception $e)
{
	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel');

?>