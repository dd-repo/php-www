<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('id'=>$_POST['id'], 'mode'=>'add', 'key'=>$_POST['key']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id='.security::encode($_POST['id']).'&key');

?>
