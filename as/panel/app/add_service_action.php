<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('app'=>$_GET['id'], 'service' => $_GET['service'], 'mode' => 'add'));

api::send('self/app/update', array('app'=>$_GET['id'], 'stop' => 1));
sleep(2);
api::send('self/app/update', array('app'=>$_GET['id'], 'start' => 1));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_GET['id']);

?>