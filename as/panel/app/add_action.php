<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/add', array('domain'=>$_POST['domain'], 'tag' => $_POST['tag'], 'runtime'=>$_POST['runtime'], 'binary'=>$_POST['binary'], 'pass'=>$_POST['pass']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>