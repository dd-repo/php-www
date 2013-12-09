<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/account/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'mode'=>'add', 'alternate'=>$_POST['alternate'] . '@' . $_POST['domain']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/user/config?id='.$_POST['id'].'&domain='.$_POST['domain']);

?>
