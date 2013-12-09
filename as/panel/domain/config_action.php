<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// update domain
$params = array('id'=>$_POST['id'], 'arecord'=>$_POST['domain_arecord'], 'mx1'=>$_POST['mx1'], 'mx2'=>$_POST['mx2']);
if( $_POST['mailer'] == 'yes' )
	$params['mailer'] = '1';
else
	$params['mailer'] = '0';
	
api::send('self/domain/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domain/config?id=' . $_POST['id']);
	
?>
