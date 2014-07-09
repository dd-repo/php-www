<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('bill/insertline', array('bill'=>$_POST['id'], 'name'=>$_POST['title'], 'description'=>$_POST['desc'], 'amount'=>$_POST['amount'], 'vat'=>$_POST['vat']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/billing/view?id=' . $_POST['id']);

?>
