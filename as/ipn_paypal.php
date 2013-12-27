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
			$result = api::send('registration/select', array('email'=>$custom[0]), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			$result = $result[0];

			$email = str_replace(array('{USER}', '{EMAIL}', '{CODE}'), array($custom[1], $custom[0], $result['code']), $lang['content']);
			mail($custom[0], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['email_title'], $email), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
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