<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/service/update', array('service'=>$_POST['service'], 'desc'=>$_POST['desc'], 'pass'=>$_POST['password']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/services/config?service=' . security::encode($_POST['service']));

?>
