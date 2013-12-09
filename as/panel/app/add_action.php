<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/add', array('domain'=>$_POST['domain'], 'runtime'=>$_POST['runtime'], 'framework'=>$_POST['framework'], 'app'=>$_POST['app'], 'url'=>$_POST['subdomain'], 'pass'=>$_POST['pass']));

if( $_POST['service'] && $_POST['version'] )
{
	$service = api::send('self/service/add', array('vendor'=>$_POST['service'], 'version'=>$_POST['version'], 'desc' => $_POST['app'] . ' ' . $app['name']));
	$template->redirect("/panel/app/add_service?id={$app['id']}");
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>