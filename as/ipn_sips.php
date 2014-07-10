<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$message = "message=" . escapeshellcmd($_POST['DATA']);
$pathfile = "pathfile=/dns/com/anotherservice/etc/sips/pathfile";
$result = exec("/dns/com/anotherservice/etc/sips/response {$pathfile} {$message}");

$result = explode ("!", $result);
$code = $result[1];
$error = $result[2];
$merchant_id = $result[3];
$merchant_country = $result[4];
$amount = $result[5];
$transaction_id = $result[6];
$payment_means = $result[7];
$transmission_date= $result[8];
$payment_time = $result[9];
$payment_date = $result[10];
$response_code = $result[11];
$payment_certificate = $result[12];
$authorisation_id = $result[13];
$currency_code = $result[14];
$card_number = $result[15];
$cvv_flag = $result[16];
$cvv_response_code = $result[17];
$bank_response_code = $result[18];
$complementary_code = $result[19];
$complementary_info= $result[20];
$return_context = $result[21];
$caddie = $result[22];
$receipt_complement = $result[23];
$merchant_language = $result[24];
$language = $result[25];
$customer_id = $result[26];
$order_id = $result[27];
$customer_email = $result[28];
$customer_ip_address = $result[29];
$capture_day = $result[30];
$capture_mode = $result[31];
$data = $result[32];
$order_validity = $result[33];
$transaction_condition = $result[34];
$statement_reference = $result[35];
$card_validity = $result[36];
$score_value = $result[37];
$score_color = $result[38];
$score_info = $result[39];
$score_threshold = $result[40];
$score_profile = $result[41];

$logfile = "/dns/com/anotherservice/etc/sips/error.log";

$fp = fopen($logfile, "a");
if( ($code == "") && ($error == "") )
{
  	fwrite($fp, "erreur appel response\n");
}
else if( $code != 0 )
{
	fwrite($fp, " API call error.\n");
	fwrite($fp, "Error message :  $error\n");
}
else
{
	fwrite( $fp, "merchant_id : $merchant_id\n");
	fwrite( $fp, "merchant_country : $merchant_country\n");
	fwrite( $fp, "amount : $amount\n");
	fwrite( $fp, "transaction_id : $transaction_id\n");
	fwrite( $fp, "transmission_date: $transmission_date\n");
	fwrite( $fp, "payment_means: $payment_means\n");
	fwrite( $fp, "payment_time : $payment_time\n");
	fwrite( $fp, "payment_date : $payment_date\n");
	fwrite( $fp, "response_code : $response_code\n");
	fwrite( $fp, "payment_certificate : $payment_certificate\n");
	fwrite( $fp, "authorisation_id : $authorisation_id\n");
	fwrite( $fp, "currency_code : $currency_code\n");
	fwrite( $fp, "card_number : $card_number\n");
	fwrite( $fp, "cvv_flag: $cvv_flag\n");
	fwrite( $fp, "cvv_response_code: $cvv_response_code\n");
	fwrite( $fp, "bank_response_code: $bank_response_code\n");
	fwrite( $fp, "complementary_code: $complementary_code\n");
	fwrite( $fp, "complementary_info: $complementary_info\n");
	fwrite( $fp, "return_context: $return_context\n");
	fwrite( $fp, "caddie : $caddie\n");
	fwrite( $fp, "receipt_complement: $receipt_complement\n");
	fwrite( $fp, "merchant_language: $merchant_language\n");
	fwrite( $fp, "language: $language\n");
	fwrite( $fp, "customer_id: $customer_id\n");
	fwrite( $fp, "order_id: $order_id\n");
	fwrite( $fp, "customer_email: $customer_email\n");
	fwrite( $fp, "customer_ip_address: $customer_ip_address\n");
	fwrite( $fp, "capture_day: $capture_day\n");
	fwrite( $fp, "capture_mode: $capture_mode\n");
	fwrite( $fp, "data: $data\n");
	fwrite( $fp, "order_validity: $order_validity\n");
	fwrite( $fp, "transaction_condition: $transaction_condition\n");
	fwrite( $fp, "statement_reference: $statement_reference\n");
	fwrite( $fp, "card_validity: $card_validity\n");
	fwrite( $fp, "card_validity: $score_value\n");
	fwrite( $fp, "card_validity: $score_color\n");
	fwrite( $fp, "card_validity: $score_info\n");
	fwrite( $fp, "card_validity: $score_threshold\n");
	fwrite( $fp, "card_validity: $score_profile\n");
	fwrite( $fp, "-------------------------------------------\n");
			
	$custom = unserialize(base64_decode($caddie));
	$infos = array('transaction_id'=>$transaction_id, 'ip'=>$custom['ip'], 'amount'=>$amount/100, 'customer_email'=>$customer_email);
		
	if( $bank_response_code == "00" )
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
						$params = array('plan' => $custom['plan'], 'billing' => 1, 'plan_type' => 'disk', 'user'=>$custom['user']);
					else
						$params = array('plan' => $custom['plan'], 'billing' => 1, 'user'=>$custom['user']);
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
					mail('contact@anotherservice.com', '[Billing] New payment succeded', json_encode($infos));
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
			mail('contact@anotherservice.com', '[Billing] New payment succeded', json_encode($infos));
			}
	}
	else
	{
		mail('contact@bus-it.com', '[Billing] New payment failed', json_encode($infos));	
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