<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('bill/insertline', array('bill'=>$_GET['id'], 'name'=>'Remise exceptionnelle', 'description'=>'Remise sur ' . $_GET['title'], 'amount'=>-$_GET['amount'], 'vat'=>$_GET['vat']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/billing/view?id=' . $_POST['id']);

?>
