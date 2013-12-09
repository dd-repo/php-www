<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

if( count($app['instances'])-1 == 0 )
	$template->redirect('/panel/app/show?id=' . $_GET['id']);

api::send('self/app/update', array('app'=>$_GET['id'], 'instances' => count($app['instances'])-1));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_GET['id']);

?>