<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('app'=>$_POST['id'], 'branch' => $_POST['branch'], 'mode'=>'add'));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . security::encode($_POST['id']) . '&branch=' . security::encode($_POST['branch']));

?>