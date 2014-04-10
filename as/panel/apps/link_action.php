<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/link', array('id'=>$_POST['id'], 'branch'=>$_POST['branch'], 'service'=>$_POST['service'], 'pass'=>$_POST['password']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id='.security::encode($_POST['id']));

?>
