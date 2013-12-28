<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/domain/update', array('id'=>$_POST['id'], 'arecord'=>$_POST['domain_arecord'], 'mx1'=>$_POST['mx1'], 'mx2'=>$_POST['mx2']));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domain/config?id=' . $_POST['id']);
	
?>