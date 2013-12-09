<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/repo/add', array('type'=>$_POST['type'], 'domain'=>$_POST['domain'], 'desc'=>$_POST['desc']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/dev');

?>