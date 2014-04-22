<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_POST['backup'] == 98 )
	$template->redirect('/panel/backups/add_action?app=' . security::encode($_POST['id']) . '&branch=' . security::encode($_POST['branch']));
if( $_POST['backup'] == 99 )
	$template->redirect('/panel/backups/add_action?full=1&app=' . security::encode($_POST['id']) . '&branch=' . security::encode($_POST['branch']));
	
$params = array('app'=>$_POST['id'], 'backup'=>$_POST['backup'], 'branch'=>$_POST['branch']);

api::send('self/app/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . security::encode($_POST['id']));

?>