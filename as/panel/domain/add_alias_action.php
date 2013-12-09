<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/alias/add', array('domain'=>$_POST['domain'], 'type'=>$_POST['type'], 'source'=>$_POST['id']));
}
catch(Exception $e)
{
	$template->redirect('/panel/domain/config?id=' . $_POST['id'] . '&e');
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domain/config?id=' . $_POST['id']);

?>