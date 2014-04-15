<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('id'=>$_GET['id'], 'mode'=>'delete', 'key'=>$_GET['key']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id='.security::encode($_GET['id']).'&key');

?>
