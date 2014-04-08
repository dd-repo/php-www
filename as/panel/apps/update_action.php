<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('app'=>$_POST['id']);

if( strlen($_POST['newpassword']) > 2 && $_POST['newpassword'] == $_POST['confirm'] )
	$params['pass'] = $_POST['newpassword'];
if( isset($_POST['tag']) )
	$params['tag'] = $_POST['tag'];
if( isset($_POST['cache']) )
	$params['cache'] = $_POST['cache'];
	
api::send('self/app/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_POST['id']);

?>