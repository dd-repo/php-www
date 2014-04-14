<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_POST['id']));
$app = $app[0];

$path = false;
if( $_FILES['certificate1']['error'] == UPLOAD_ERR_OK  && $_FILES['certificate2']['error'] == UPLOAD_ERR_OK )
{
	move_uploaded_file($_FILES['certificate1']['tmp_name'], "as/upload/{$app['name']}-crt+ca.pem");
	move_uploaded_file($_FILES['certificate2']['tmp_name'], "as/upload/{$app['name']}-key.pem");
	
	$path = str_replace("Apps/{$app['name']}", "", $app['homeDirectory']) . "etc/ssl/{$app['name']}";
}
else if( $_FILES['certificate1']['error'] == UPLOAD_ERR_OK || $_FILES['certificate2']['error'] == UPLOAD_ERR_OK )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error_file'];
	
	$template->redirect('/panel/apps/show?id=' . security::encode($_POST['id']));
}

$params = array('app'=>$_POST['id']);

if( strlen($_POST['newpassword']) > 2 && $_POST['newpassword'] == $_POST['confirm'] )
	$params['pass'] = $_POST['newpassword'];
if( isset($_POST['tag']) )
	$params['tag'] = $_POST['tag'];
if( isset($_POST['cache']) )
	$params['cache'] = $_POST['cache'];
if( $path )
	$params['certificate'] = $path;
	
api::send('self/app/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . security::encode($_POST['id']));

?>