<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$req = 'cmd=_notify-validate';

foreach( $_POST as $key => $value )
{
	$value = urlencode(stripslashes($value));
	$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
	$req .= "&$key=$value";
}

// assign posted variables to local variables
$data['item_name']			= $_POST['item_name'];
$data['item_number']		= $_POST['item_number'];
$data['payment_status']		= $_POST['payment_status'];
$data['payment_amount']		= $_POST['mc_gross'];
$data['payment_currency']	= $_POST['mc_currency'];
$data['txn_id']				= $_POST['txn_id'];
$data['receiver_email']		= $_POST['receiver_email'];
$data['payer_email']		= $_POST['payer_email'];
$data['custom']				= $_POST['custom'];

$custom = explode(" ", $data['custom']);

$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if( !$fp )
{
	// HTTP ERROR
}
else
{
	$message = json_encode($data);
	fputs ($fp, $header . $req);
	
	while( !feof($fp) )
	{
		$res = fgets($fp, 1024);
		
		if( strcmp($res, "VERIFIED") == 0 )
		{
			$quotas = api::send('quota/list', array('user'=>$custom[1]), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

			foreach( $quotas as $q )
			{
				if( $q['name'] == 'MEMORY' )
					$quota = $q;
				elseif( $q['name'] == 'DISK' )
					$dquota = $q;
			}

			switch( $custom[3] )
			{
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

			if( $success === true )
			{
				$params = array('plan' => $_GET['plan'], 'user'=>$custom[1]);
				api::send('user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				$params = array('user' => $custom[1], 'quota' => 'MEMORY', 'max' => $ram);
				api::send('quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				$params = array('user' => $custom[1], 'quota' => 'SERVICES', 'max' => $services);
				api::send('quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				
				if( $dquota['max'] <= $disk )
				{
					$params = array('user' => $custom[1], 'quota' => 'DISK', 'max' => $disk);
					api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				}
								
				// SEND MAIL
				$mail = str_replace(array('{OFFER}', '{SERVICES}', '{NAME}'), array($ram, $services, $custom[1]), $lang['mail']);
				$result = mail($custom[0], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");
				mail('contact@anotherservice.com', '[Billing] New payment succeded', $message);
		}
		else if( strcmp($res, "INVALID") == 0 )
		{
			mail('contact@anotherservice.com', '[Billing] New payment failed', $message);
		}
	}
}

fclose ($fp);

?>