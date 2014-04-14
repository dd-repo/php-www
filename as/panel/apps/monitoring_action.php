<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('app'=>$_POST['id'], 'branch'=>$_POST['branch'], 'alert'=>$_POST['alert'], 'monitor'=>$_POST['monitor']);

api::send('self/app/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/apps/show?id=' . security::encode($_POST['id']));

?>