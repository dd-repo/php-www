<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$me = api::send('self/whoami');
$me = $me[0];

$quotas = api::send('self/quota/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'MEMORY' )
		$quota = $q;
	elseif( $q['name'] == 'DISK' )
		$dquota = $q;
}

switch( $_GET['plan'] )
{
	case '99':
		$ram = 256;
		$services = 1;
		$disk = 1000;
		$success = true;
	break;
	case '1':
		$ram = 1024;
		$services = 4;
		$disk = 1000;
		$success = true;
	break;
	case '2':
		$ram = 4096;
		$services = 16;
		$disk = 1000;
		$success = true;
	break;
	case '3':
		$ram = 8192;
		$services = 32;
		$disk = 10000;
		$success = true;
	break;
	case '4':
		$ram = 16384;
		$services = 64;
		$disk = 10000;
		$success = true;
	break;
	case '5':
		$ram = 32768;
		$services = 128;
		$disk = 50000;
		$success = true;
	break;	
	case '6':
		$ram = 65536;
		$services = 256;
		$disk = 50000;
		$success = true;
	break;
	default:
		$success = false;
}

if( $quota['used'] > $ram )
{
	$_SESSION['MESSAGE']['TYPE'] = 'failure';
	$_SESSION['MESSAGE']['TEXT']= $lang['impossible'];
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/panel/plans');
}

if( $success === true )
{
	$params = array('plan' => $_GET['plan']);
	api::send('self/update', $params);
	$params = array('user' => $me['id'], 'quota' => 'MEMORY', 'max' => $ram);
	api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$params = array('user' => $me['id'], 'quota' => 'SERVICES', 'max' => $services);
	api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	if( $dquota['max'] <= $disk )
	{
		$params = array('user' => $me['id'], 'quota' => 'DISK', 'max' => $disk);
		api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	}
	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	// SEND MAIL
	$mail = str_replace(array('{OFFER}', '{SERVICES}', '{NAME}'), array($ram, $services, $me['firstname'] . ' ' . $me['lastname']), $lang['mail']);
	$result = mail($me['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");
}
else
{
	$_SESSION['MESSAGE']['TYPE'] = 'failure';
	$_SESSION['MESSAGE']['TEXT']= $lang['uknown'];		
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/plans');	

?>