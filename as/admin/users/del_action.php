<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$user = api::send('user/list', array('id'=>$_POST['user']));
$user = $user[0];

api::send('user/del', array('id'=>$_POST['user']));
	
$email = str_replace(array('{USER}'), array($user['name']), $lang['content']);
mail($user['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $email), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin');

?>