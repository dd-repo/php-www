<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$_SESSION['APP_RUNTIME'] = $_POST['runtime'];
$_SESSION['APP_STANDALONE'] = $_POST['runtime'];

$params = array();
if( $_POST['standalone'] == 1 )
{
	if( strlen($_POST['binary']) < 3 || $_POST['binary'] == $lang['binary'] )
		$template->redirect('/panel/app/add?estandalone');
		
	$params['binary'] = $_POST['binary'];
}

$params['domain'] = $_POST['domain'];
$params['tag'] = $_POST['tag'];
$params['runtime'] = $_POST['runtime'];
$params['pass'] = $_POST['pass'];
$params['mail'] = $userinfo['email'];

$app = api::send('self/app/add', $params);
api::send('self/subdomain/add', array('domain'=>'anotherservice.net', 'subdomain'=>strtolower($app['name'])));
api::send('self/app/update', array('app'=>$app['id'], 'url' => strtolower($app['name']) . '.anotherservice.net', 'branch' => 'master', 'mode'=>'add'));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>