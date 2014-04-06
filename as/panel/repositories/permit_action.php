<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/repo/update', array('id'=>$_GET['id'], 'join'=>'add', 'member'=>$_GET['member']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/repo/config?id='.$_GET['id']);

?>
