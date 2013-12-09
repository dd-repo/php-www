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
			api::send('bill/update', array('bill'=>$custom[0], 'status'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			
			if( $custom[1] && $custom[2] )
			{
				mail('contact@bus-it.com', '[Billing] New payment succeded', $message);
				$quota = api::send('quota/user/list', array('user'=>$custom[1]),$GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				foreach( $quota as $q )
				{
					if( $q['name'] == 'PREPAID' )
						$current = $q['used'];
				}
				$new = $current+$custom[2];
				$result = api::send('quota/user/update', array('user'=>$custom[1], 'quota'=>'PREPAID', 'current'=>$new), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			}
		}
		else if( strcmp($res, "INVALID") == 0 )
		{
			api::send('bill/update', array('id'=>$custom[0], 'status'=>2), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			mail('contact@bus-it.com', '[Billing] New payment failed', $message);
		}
	}
}

fclose ($fp);

?>