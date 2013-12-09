<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/account/del', array('domain'=>$_GET['domain'],'id'=>$_GET['id']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
		$template->redirect('/panel/user/list?domain=' . $_POST['domain']);

?>
