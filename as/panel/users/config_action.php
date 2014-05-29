<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_POST['ssh'] != 1 )
	$_POST['ssh'] = 0;

try
{
	api::send('self/account/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'ssh'=>$_POST['ssh'], 'lastname'=>$_POST['lastname']));
}
catch(Exception $e)
{
	
}

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/users/config?id='.$_POST['id'].'&domain='.$_POST['domain']);

?>
