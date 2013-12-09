<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_SESSION['LOGIN_ACCOUNT']['ID'] && $_SESSION['LOGIN_ACCOUNT']['DOMAIN'] )
	api::send('account/update', array('id'=> $_SESSION['LOGIN_ACCOUNT']['ID'], 'domain'=>$_SESSION['LOGIN_ACCOUNT']['DOMAIN'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT'] = $lang['success'];
			
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/account/config');

?>
