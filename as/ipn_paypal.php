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

$custom = unserialize(base64_decode($data['custom']));

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
	$infos = array('transaction_id'=>$data['txn_id'], 'ip'=>$custom['ip'], 'amount'=>$data['payment_amount'], 'customer_email'=>$data['payer_email']);
	$message = json_encode($infos);
	
	fputs ($fp, $header . $req);
	
	while( !feof($fp) )
	{
		$res = fgets($fp, 1024);
		
		if( strcmp($res, "VERIFIED") == 0 )
		{
			if( $custom['first'] == 1 )
			{
				try
				{
					$quotas = api::send('quota/user/list', array('user'=>$custom['user']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

					foreach( $quotas as $q )
					{
						if( $q['name'] == 'MEMORY' )
							$quota = $q;
						elseif( $q['name'] == 'DISK' )
							$dquota = $q;
					}

					switch( $custom['plan'] )
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
						break;
						case '8':
							$disk = 10000;
							$success = true;
							$diskplan = true;
						break;
						case '9':
							$disk = 50000;
							$success = true;	
							$diskplan = true;
						break;
						case '10':
							$disk = 100000;
							$success = true;
							$diskplan = true;
						break;
						case '11':
							$disk = 500000;
							$success = true;	
							$diskplan = true;
						break;
						case '12':
							$disk = 1000000;
							$success = true;
							$diskplan = true;
						break;	
						default:
							$success = false;
					}

					if( $success === true )
					{
						$ramPrice = computeRam($ram);
						$diskPrice = computeDisk($ram, $disk);

						if( $ramPrice['price'] > 0 )
						{
							$bill = api::send('bill/insert', array('user'=>$custom['user']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
							api::send('bill/insertline', array('bill'=>$bill['id'], 'name'=>$ramPrice['name'], 'description'=>$ramPrice['desc'], 'amount'=>$ramPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	
							if( $diskPrice['price'] > 0 )
								api::send('bill/insertline', array('user'=>$custom['user'], 'bill'=>$bill['id'], 'name'=>$diskPrice['name'], 'description'=>$diskPrice['desc'], 'amount'=>$diskPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	
							api::send('bill/update', array('bill'=>$bill['id'], 'status'=>2), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						}
						
						if( $diskplan === true )
							$params = array('plan' => $custom['plan'], 'plan_type' => 'disk', 'user'=>$custom['user']);
						else
							$params = array('plan' => $custom['plan'], 'user'=>$custom['user']);
						api::send('user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						
						if( $diskplan !== true )
						{
							$params = array('user' => $custom['user'], 'quota' => 'MEMORY', 'max' => $ram);
							api::send('quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
							$params = array('user' => $custom['user'], 'quota' => 'SERVICES', 'max' => $services);
							api::send('quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						}
						
						$quotas = api::send('quota/user/list', array('user' => $custom['user']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						foreach( $quotas as $q )
						{
							if( $q['name'] == 'DISK' )
								$dquota = $q;
						}

						if( $diskplan === true )
						{
							$params = array('user' =>  $custom['user'], 'quota' => 'DISK', 'max' => $disk);
							api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						}
						else
						{
							if( $dquota['max'] <= $disk )
							{
								$params = array('user' =>  $custom['user'], 'quota' => 'DISK', 'max' => $disk);
								api::send('/quota/user/update', $params, $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
							}	
						}
						
						$quotas = api::send('quota/user/list', array('user' => $custom['user']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
						foreach( $quotas as $q )
						{
							if( $q['name'] == 'DISK' )
								$dquota = $q;
							if( $q['name'] == 'MEMORY' )
								$mquota = $q;
							if( $q['name'] == 'SERVICES' )
								$squota = $q;
						}
						
						switch( $custom['lang'] )
						{
							case 'FR':
								$subject = "Modification de votre offre";
								$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que nous avons bien pris en considération la modification de votre offre sur la plateforme d'hébergement <a href='http://www.anotherservice.com'>Another Service</a>.<br /><br />
		Vous disposez maintenant de <strong>{RAM}Mo de mémoire RAM</strong>, de <strong>{SERVICES} services</strong>, de <strong>{DISK} Mo d'espace disque</strong> ainsi que de l'ensemble des <a href='http://www.anotherservice.com/service/hosting'>services associés</a> à ce pack.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>https://www.anotherservice.com/panel/billing/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
							break;
							default:
								$subject = "Modification de votre offre";
								$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que nous avons bien pris en considération la modification de votre offre sur la plateforme d'hébergement <a href='http://www.anotherservice.com'>Another Service</a>.<br /><br />
		Vous disposez maintenant de <strong>{RAM}Mo de mémoire RAM</strong>, de <strong>{SERVICES} services</strong>, de <strong>{DISK} Mo d'espace disque</strong> ainsi que de l'ensemble des <a href='http://www.anotherservice.com/service/hosting'>services associés</a> à ce pack.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a href='https://www.bus-it.com/panel/credits/view?id={BILL}'>https://www.bus-it.com/panel/credits/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
						}
						
						// SEND MAIL
						$mail = str_replace(array('{RAM}', '{SERVICES}', '{DISK}', '{NAME}', '{BILL}'), array($mquota['max'], $squota['max'], $dquota['max'], $custom['user'], $bill['id']), $mailcontent);
						$result = mail($custom['email'], $subject, str_replace(array('{TITLE}', '{CONTENT}'), array($subject, $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");
						mail('contact@anotherservice.com', '[Billing] New payment succeded', $message);
					}
				}
				catch( Exception $e )
				{
					mail('contact@anotherservice.com', '[Billing] New payment but errors', $e);
				}
			}
			else
			{
				switch( $custom['lang'] )
				{
					case 'FR':
						$subject = "Paiement de votre facture";
						$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que le paiement de votre facture s'est déroulé avec succès.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>https://www.anotherservice.com/panel/billing/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
					break;
					default:
						$subject = "Paiement de votre facture";
						$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que le paiement de votre facture s'est déroulé avec succès.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>https://www.anotherservice.com/panel/billing/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
				}
				
				api::send('bill/update', array('bill'=>$custom['bill'], 'status'=>2), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				
				// SEND MAIL
				$mail = str_replace(array('{BILL}', '{NAME}'), array($custom['bill'], $custom['user']), $mailcontent);
				$result = mail($custom['email'], $subject, str_replace(array('{TITLE}', '{CONTENT}'), array($subject, $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");
				mail('contact@anotherservice.com', '[Billing] New payment succeded', $message);
			}
		}
		else if( strcmp($res, "INVALID") == 0 )
		{
			mail('contact@anotherservice.com', '[Billing] New payment failed', $message);
		}
	}
}

fclose ($fp);

function computeRam($ram)
{
	switch( $ram )
	{
		case '1024':
			return array('name'=>'Pack 1Go', 'desc'=>'1Go de mémoire, 4 services', 'price'=>29);
		break;
		case '4096':
			return array('name'=>'Pack 4Go', 'desc'=>'4Go de mémoire, 16 services', 'price'=>99);		
		break;
		case '8192':
			return array('name'=>'Pack 8Go', 'desc'=>'8Go de mémoire, 32 services', 'price'=>180);
		break;
		case '16384':
			return array('name'=>'Pack 16Go', 'desc'=>'16Go de mémoire, 64 services', 'price'=>320);
		break;
		case '32768':
			return array('name'=>'Pack 32Go', 'desc'=>'32Go de mémoire, 128 services', 'price'=>560);	
		break;
		case '65536':
			return array('name'=>'Pack 64Go', 'desc'=>'64Go de mémoire, 256 services', 'price'=>999);
		break;
	}
}

function computeDisk($ram, $disk)
{
	switch( $disk )
	{
		case '1000':
			return array('price'=>0);
		case '10000':
			if( $ram >= 8192 )
				return array('price'=>0);
			else
				return array('name'=>'Disque 10Go', 'desc'=>'Espace disque supplémentaire 10Go', 'price'=>5);
		break;
		case '50000':
			if( $ram >= 32768 )
				return array('price'=>0);
			else
				return array('name'=>'Disque 50Go', 'desc'=>'Espace disque supplémentaire 50Go', 'price'=>20);
		break;
		case '100000':
			return array('name'=>'Disque 100Go', 'desc'=>'Espace disque supplémentaire 100Go', 'price'=>30);
		break;
		case '500000':
			return array('name'=>'Disque 500Go', 'desc'=>'Espace disque supplémentaire 500Go', 'price'=>100);
		break;
		case '1000000':
			return array('name'=>'Disque 1To', 'desc'=>'Espace disque supplémentaire 1To', 'price'=>150);
		break;
	}
}

?>