<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/team/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/groups/config?id='.$_POST['id'].'&domain='.$_POST['domain']);

?>