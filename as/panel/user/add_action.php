<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

//api::send('self/domain/update', array('domain'=>$_POST['domain'], 'mailer'=>1));
api::send('self/account/add', array('account'=>$_POST['mail'], 'domain'=>$_POST['domain'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/user/list?domain=' . $_POST['domain']);

?>
