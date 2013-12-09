<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

api::send('self/app/update', array('app'=>$_GET['id'], 'memory' => $app['instances'][0]['memory']['quota']*2));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_GET['id']);

?>
