<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// 1) rekvoke all grants that are not selected
$user = api::send('grant/user/list', array('user'=>$_POST['id']));

if( !isset($_POST['grant']) || !is_array($_POST['grant']) )
	$_POST['grant'] = array();

if( count($user) > 0 )
{
	$grants = array();
	foreach( $user as $u )
	{
		if( !in_array($u['id'], $_POST['grant']) )
			$grants[] = $u['id'];
	}

	if( count($grants) > 0 )
		api::send('grant/user/del', array('user'=>$_POST['id'], 'grants'=>implode(',', $grants)));
}

// 2) grant selected grants (existing ones will be ignored)
if( count($_POST['grant']) > 0 )
{
	api::send('grant/user/add', array('user'=>$_POST['id'], 'grants'=>implode(',', $_POST['grant'])));
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id=' . $_POST['id']);

?>