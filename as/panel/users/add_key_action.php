<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/account/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'mode'=>'add', 'key'=>$_POST['key']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/users/config?id='.security::encode($_POST['id']).'&domain='.security::encode($_POST['domain']));

?>
