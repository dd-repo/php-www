<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('app'=>$_POST['id'], 'url' => $_POST['url'], 'branch' => $_POST['branch'], 'mode'=>'add'));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . $_POST['id']);

?>