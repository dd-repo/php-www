<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

api::send('self/repo/add', array('type'=>$_POST['type'], 'domain'=>$_POST['domain'], 'mail'=>$userinfo['email'], 'desc'=>$_POST['desc']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/repositories');

?>