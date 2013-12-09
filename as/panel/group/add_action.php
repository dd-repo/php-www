<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/team/add', array('team'=>$_POST['mail'], 'domain'=>$_POST['domain'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/user/list?domain=' . $_POST['domain']);

?>
