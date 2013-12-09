<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/domain/add', array('domain'=>$_POST['domain']));
}
catch(Exception $e)
{
	$template->redirect('/panel/domain/add?e');
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domain');

?>
