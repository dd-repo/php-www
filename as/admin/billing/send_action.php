<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$bill = api::send('bill/select', array('bill'=>$_GET['id']));
$bill = $bill[0];

$userinfo = api::send('user/list', array('user'=>$bill['user']['id']));
$userinfo = $userinfo[0];

$mail = str_replace(array('{BILL}', '{NAME}', '{AMOUNT}', '{DATE}'), array($bill['id'], $userinfo['user_name'], $bill['amount_ati'], date($lang['dateformat'], $bill['date'])), $lang['mailcontent']);
$result = mail($userinfo['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/billing/view?id=' . $_GET['id']);

?>
