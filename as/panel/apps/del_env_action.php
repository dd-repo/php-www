<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('app'=>$_GET['id'], 'branch' => $_GET['branch'], 'mode'=>'delete'));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . security::encode($_GET['id']) . '&branch=master');

?>