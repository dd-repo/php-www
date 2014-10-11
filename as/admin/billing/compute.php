<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array(), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

foreach( $users as $u )
{
	if( $u['billing'] > 0 )
	{
		$bills = api::send('bill/list', array('user'=>$u['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

		if( !$bills[0]['date'] )
			$bills[0]['date'] = 0;
		
		if( $bills[0]['date'] < strtotime('this day previous month') )
		{
			$quotas = api::send('quota/user/list', array('user'=>$u['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			
			foreach( $quotas as $q )
			{
				if( $q['name'] == 'MEMORY' )
					$ram = $q['max'];
				if( $q['name'] == 'DISK' )
					$disk = $q['max'];
				if( $q['name'] == 'APPS' )
					$apps = $q['max'];
			}

			$ramPrice = computeRam($ram);
			$appsPrice = computeApps($apps);

			$bill = api::send('bill/insert', array('user'=>$u['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			
			if( $ramPrice['price'] > 0 )
			{
				$diskPrice = computeDisk($ram, $disk);
				api::send('bill/insertline', array('bill'=>$bill['id'], 'name'=>$ramPrice['name'], 'description'=>$ramPrice['desc'], 'amount'=>$ramPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				
				if( $diskPrice['price'] > 0 )
					api::send('bill/insertline', array('user'=>$u['id'], 'bill'=>$bill['id'], 'name'=>$diskPrice['name'], 'description'=>$diskPrice['desc'], 'amount'=>$diskPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);	
			}
			else if( $appsPrice['price'] > 0 )
			{
				$diskPrice = computeHostingDisk($disk);
				api::send('bill/insertline', array('bill'=>$bill['id'], 'name'=>$appsPrice['name'], 'description'=>$appsPrice['desc'], 'amount'=>$appsPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

				if( $diskPrice['price'] > 0 )
					api::send('bill/insertline', array('user'=>$u['id'], 'bill'=>$bill['id'], 'name'=>$diskPrice['name'], 'description'=>$diskPrice['desc'], 'amount'=>$diskPrice['price'], 'vat'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
			}
			
			if( $u['billing'] == 2 )
				api::send('bill/update', array('bill'=>$bill['id'], 'status'=>1));
			
			switch( $u['language'] )
			{
				case 'FR':
					$subject = "Votre facture du " . date('d/m/Y') . " est disponible";
					$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que votre facture pour le mois en cours est disponible dans votre <a style='color: #56c8f9; text-decoration: none;' href='https://www.anotherservice.com/panel/billing'>interface de gestion</a> Another Service. 
		Vous pouvez la <a style='color: #56c8f9; text-decoration: none;' href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>payer directement</a> par carte bancaire.<br /><br />
		Si vous avez souscrit au prélèvement automatique, vous
		pouvez ignorer cet email et votre facture sera marquée payée une fois le prélèvement effectué.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a style='color: #56c8f9; text-decoration: none;' href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>https://www.anotherservice.com/panel/billing/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
				break;
				default:
					$subject = "Votre facture du " . date('d/m/Y') . " est disponible";
					$mailcontent = "Bonjour {NAME},<br />
		<br />
		Nous vous informons que votre facture pour le mois en cours est disponible dans votre <a style='color: #56c8f9; text-decoration: none;' href='https://www.anotherservice.com/panel/billing'>interface de gestion</a> Another Service. 
		Vous pouvez la payer directement par carte bancaire.<br /><br /> Si vous avez souscrit au prélèvement automatique, vous pouvez ignorer cet email et votre facture sera marquée payée une fois le prélèvement effectué.<br /><br />
		Vous pouvez retrouver la facture dans votre interface à l'adresse : <a style='color: #56c8f9; text-decoration: none;' href='https://www.anotherservice.com/panel/billing/view?id={BILL}'>https://www.anotherservice.com/panel/billing/view?id={BILL}</a><br /><br />
		Nous vous remercions de votre confiance.<br /><br />
		Cordialement,<br />
		L'équipe Another Service";
			}
			
			$mail = str_replace(array('{NAME}', '{BILL}'), array($u['name'], $bill['id']), $mailcontent);
			try
			{
				$result = mail($u['email'], $subject, str_replace(array('{TITLE}', '{CONTENT}'), array($subject, $mail), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");
			}
			catch( Exception $e )
			{
				
			}
		}
	}
}

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

function computeApps($apps)
{
	switch( $apps )
	{
		case '1':
			return array('name'=>'Pack 1 application', 'desc'=>'500Mo de disque, 1 service', 'price'=>2);
		break;
		case '3':
			return array('name'=>'Pack 3 applications', 'desc'=>'1Go de disque, 2 services', 'price'=>5);		
		break;
		case '6':
			return array('name'=>'Pack 6 applications', 'desc'=>'2Go de disque, 2 services', 'price'=>10);
		break;
		case '12':
			return array('name'=>'Pack 12 applications', 'desc'=>'4Go de disque, 4 services', 'price'=>20);
		break;
		default:
			return false;
	}
}

function computeHostingDisk($disk)
{
	switch( $disk )
	{
		case '10000':
			return array('name'=>'Disque 10Go', 'desc'=>'Espace disque supplémentaire 10Go', 'price'=>5);
		break;
		case '50000':
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

echo "OK";

?>