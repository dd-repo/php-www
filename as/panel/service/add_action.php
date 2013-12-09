<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/service/add', array('vendor'=>$_POST['vendor'], 'version'=>$_POST['version'], 'desc'=>$_POST['desc'], 'pass'=>$_POST['pass']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/service');

?>
