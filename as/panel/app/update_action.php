<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( strlen($_POST['newpassword']) > 2 && $_POST['newpassword'] == $_POST['confirm'] )
	api::send('self/app/update', array('app'=>$_POST['id'], 'tag' => $_POST['tag'], 'pass' => $_POST['newpassword']));
else
	api::send('self/app/update', array('app'=>$_POST['id'], 'tag' => $_POST['tag']));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_POST['id']);

?>