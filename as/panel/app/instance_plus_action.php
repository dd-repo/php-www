<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id'], 'extended'=>1));
$app = $app[0];

api::send('self/app/update', array('app'=>$_GET['id'], 'branch'=>$_GET['branch'], 'instances' => count($app['branches'][$_GET['branch']]['instances'])+1));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/app/show?id=' . $_GET['id']);

?>