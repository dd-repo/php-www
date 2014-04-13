<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/team/del', array('domain'=>$_GET['domain'],'id'=>$_POST['group']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
		$template->redirect('/panel/users/list?domain=' . security::encode($_GET['domain']));

?>

