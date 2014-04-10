<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/unlink', array('id'=>$_GET['id'], 'branch'=>$_GET['branch'], 'service'=>$_GET['service']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id='.security::encode($_GET['id']));

?>
