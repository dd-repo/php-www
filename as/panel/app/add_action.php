<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_SESSION['APP_RUNTIME'] = $_POST['runtime'];
$_SESSION['APP_STANDALONE'] = $_POST['runtime'];

if( $_POST['standalone'] == 1 )
{
	if( strlen($_POST['binary']) < 3 || $_POST['binary'] == $lang['binary'] )
		$template->redirect('/panel/app/add?estandalone');
}

$app = api::send('self/app/add', array('domain'=>$_POST['domain'], 'tag' => $_POST['tag'], 'runtime'=>$_POST['runtime'], 'binary'=>$_POST['binary'], 'pass'=>$_POST['pass']));
//api::send('self/app/update', array('app'=>$_POST['id'], 'url' => $_POST['url'], 'branch' => 'master', 'mode'=>'add'));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>