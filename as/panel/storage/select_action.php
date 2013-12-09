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
	if( $q['name'] == 'DISK' )
		$quota = $q;
}

switch( $_GET['plan'] )
{
	case '8':
		$disk = 10000;
		$success = true;
	break;
	case '9':
		$disk = 50000;
		$success = true;	
	break;
	case '10':
		$disk = 100000;
		$success = true;
	break;
	case '11':
		$disk = 500000;
		$success = true;	
	break;
	case '12':
		$disk = 1000000;
		$success = true;
	break;	
	default:
		$success = false;
}

if( $quota['used'] > $disk )
{
	$_SESSION['MESSAGE']['TYPE'] = 'failure';
	$_SESSION['MESSAGE']['TEXT']= $lang['impossible'];
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/panel/storage');
}

if( $success === true )
{
	$params = array('plan' => $_GET['plan'], 'plan_type' => 'disk');
	api::send('self/update', $params);
	$params = array('user' => $me['id'], 'quota' => 'DISK', 'max' => $disk);
	api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	// SEND MAIL
	$mail = str_replace(array('{OFFER}', '{NAME}'), array(round($disk/1000), $me['firstname'] . ' ' . $me['lastname']), $lang['mail']);
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
	template::redirect('/panel/storage');	

?>