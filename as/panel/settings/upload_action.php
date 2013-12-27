<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

if( $_FILES['avatar']['error'] == UPLOAD_ERR_OK )
	move_uploaded_file($_FILES['avatar']['tmp_name'], 'on/images/users/'.$userinfo['id'].'.png'); 

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/settings');
	
?>