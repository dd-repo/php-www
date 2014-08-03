<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$bill = api::send('bill/select', array('bill'=>$_GET['id']));
$bill = $bill[0];

print_r($bill);

exit();

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/billing/view?id=' . $_GET['id']);

?>
