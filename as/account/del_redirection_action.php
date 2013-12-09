<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_SESSION['LOGIN_ACCOUNT']['ID'] && $_SESSION['LOGIN_ACCOUNT']['DOMAIN'] )
	api::send('account/update', array('id'=> $_SESSION['LOGIN_ACCOUNT']['ID'], 'domain'=>$_SESSION['LOGIN_ACCOUNT']['DOMAIN'], 'mode'=>'delete', 'redirection'=>$_GET['redirection']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/account/config');

?>
