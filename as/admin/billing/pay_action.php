<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('bill/update', array('bill'=>$_GET['id'], 'status'=>2));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/billing/view?id=' . $_GET['id']);

?>
