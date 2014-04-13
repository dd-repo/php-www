<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/del', array('id'=>$_GET['id']));
api::send('self/subdomain/del', array('domain'=>'anotherservice.net', 'subdomain'=>strtolower($_GET['name'])));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel');

?>