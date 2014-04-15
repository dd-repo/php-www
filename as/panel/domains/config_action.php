<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/domain/update', array('id'=>$_POST['id'], 'arecord'=>$_POST['domain_arecord'], 'mx1'=>$_POST['mx1'], 'mx2'=>$_POST['mx2']));

if( $_POST['domain_mailer'] == 1 )
	api::send('self/domain/update', array('domain'=>$_POST['domain'], 'mailer'=>1));
else
	api::send('self/domain/update', array('domain'=>$_POST['domain'], 'mailer'=>0));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains/config?id=' . $_POST['id']);
	
?>