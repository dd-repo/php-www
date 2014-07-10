<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('fast'=>1));

/*if( date('j') != 1 )
{
	echo "We are not the 1<sup>st</sup> of the month!";
	exit();
}*/

foreach( $users as $u )
{
	if( $u['billing'] == 1 )
	{
		$quotas = api::send('quota/user/list', array('user'=>$u['id']));

		foreach( $quotas as $q )
		{
			if( $q['name'] == 'MEMORY' )
				$ram = $q['max'];
			if( $q['name'] == 'DISK' )
				$disk = $q['max'];
		}
		
		$ramPrice = computeRam($ram);
		$diskPrice = computeDisk($ram, $disk);

		if( $ramPrice['price'] > 0 )
		{
			$bill = api::send('bill/insert', array('user'=>$u['id']));
		
			api::send('bill/insertline', array('bill'=>$bill['id'], 'name'=>$ramPrice['name'], 'description'=>$ramPrice['desc'], 'amount'=>$ramPrice['price'], 'vat'=>20));
		
			if( $diskPrice['price'] > 0 )
				api::send('bill/insertline', array('user'=>$u['id'], 'bill'=>$bill['id'], 'name'=>$diskPrice['name'], 'description'=>$diskPrice['desc'], 'amount'=>$diskPrice['price'], 'vat'=>20));
		
			api::send('bill/update', array('bill'=>$bill['id'], 'status'=>1));
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

echo "OK";

?>