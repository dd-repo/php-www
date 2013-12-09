<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$me = api::send('self/whoami');
$me = $me[0];

function isValidIban($iban)
{
	/*R�gles de validation par pays*/	
	static $rules = array(
	'AL'=>'[0-9]{8}[0-9A-Z]{16}',
	'AD'=>'[0-9]{8}[0-9A-Z]{12}',
	'AT'=>'[0-9]{16}',
	'BE'=>'[0-9]{12}',
	'BA'=>'[0-9]{16}',
	'BG'=>'[A-Z]{4}[0-9]{6}[0-9A-Z]{8}',
	'HR'=>'[0-9]{17}',
	'CY'=>'[0-9]{8}[0-9A-Z]{16}',
	'CZ'=>'[0-9]{20}',
	'DK'=>'[0-9]{14}',
	'EE'=>'[0-9]{16}',
	'FO'=>'[0-9]{14}',
	'FI'=>'[0-9]{14}',
	'FR'=>'[0-9]{10}[0-9A-Z]{11}[0-9]{2}',
	'GE'=>'[0-9A-Z]{2}[0-9]{16}',
	'DE'=>'[0-9]{18}',
	'GI'=>'[A-Z]{4}[0-9A-Z]{15}',
	'GR'=>'[0-9]{7}[0-9A-Z]{16}',
	'GL'=>'[0-9]{14}',
	'HU'=>'[0-9]{24}',
	'IS'=>'[0-9]{22}',
	'IE'=>'[0-9A-Z]{4}[0-9]{14}',
	'IL'=>'[0-9]{19}',
	'IT'=>'[A-Z][0-9]{10}[0-9A-Z]{12}',
	'KZ'=>'[0-9]{3}[0-9A-Z]{3}[0-9]{10}',
	'KW'=>'[A-Z]{4}[0-9]{22}',
	'LV'=>'[A-Z]{4}[0-9A-Z]{13}',
	'LB'=>'[0-9]{4}[0-9A-Z]{20}',
	'LI'=>'[0-9]{5}[0-9A-Z]{12}',
	'LT'=>'[0-9]{16}',
	'LU'=>'[0-9]{3}[0-9A-Z]{13}',
	'MK'=>'[0-9]{3}[0-9A-Z]{10}[0-9]{2}',
	'MT'=>'[A-Z]{4}[0-9]{5}[0-9A-Z]{18}',
	'MR'=>'[0-9]{23}',
	'MU'=>'[A-Z]{4}[0-9]{19}[A-Z]{3}',
	'MC'=>'[0-9]{10}[0-9A-Z]{11}[0-9]{2}',
	'ME'=>'[0-9]{18}',
	'NL'=>'[A-Z]{4}[0-9]{10}',
	'NO'=>'[0-9]{11}',
	'PL'=>'[0-9]{24}',
	'PT'=>'[0-9]{21}',
	'RO'=>'[A-Z]{4}[0-9A-Z]{16}',
	'SM'=>'[A-Z][0-9]{10}[0-9A-Z]{12}',
	'SA'=>'[0-9]{2}[0-9A-Z]{18}',
	'RS'=>'[0-9]{18}',
	'SK'=>'[0-9]{20}',
	'SI'=>'[0-9]{15}',
	'ES'=>'[0-9]{20}',
	'SE'=>'[0-9]{20}',
	'CH'=>'[0-9]{5}[0-9A-Z]{12}',
	'TN'=>'[0-9]{20}',
	'TR'=>'[0-9]{5}[0-9A-Z]{17}',
	'AE'=>'[0-9]{19}',
	'GB'=>'[A-Z]{4}[0-9]{14}'
	);
	/*On v�rifie la longueur minimale*/
	if(mb_strlen($iban) < 18)
	{
		return false;
	}
	/*On r�cup�re le code ISO du pays*/
	$ctr = substr($iban,0,2);
	if(isset($rules[$ctr]) === false)
	{
		return false;
	}
	/*On r�cup�re la r�gle de validation en fonction du pays*/
	$check = substr($iban,4);
	/*Si la r�gle n'est pas bonne l'IBAN n'est pas valide*/
	if(preg_match('~'.$rules[$ctr].'~',$check) !== 1)
	{
		return false;
	}
	/*On r�cup�re la chaine qui permet de calculer la validation*/
	$check = $check.substr($iban,0,4);
	/*On remplace les caract�res alpha par leurs valeurs d�cimales*/
	$check = str_replace(
	array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T','U', 'V', 'W', 'X', 'Y', 'Z'),
	array('10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35'),
	$check
	);
	/*On effectue la v�rification finale*/
	return bcmod($check,97) === '1';
}

$params = array('user'=>$_POST['id']);
if( isset($_POST['iban']) && strlen($_POST['iban']) > 0 )
{
	if( !isValidIban($_POST['iban']) )
	{
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_iban'];
		template::redirect('/panel/billing/update');
	}
	
	$params['iban'] = $_POST['iban'];
	
	mail("contact@anotherservice.com", "[Billing] Update payment info", "User {$me['name']} updated billing infos", "From: no-reply@anotherservice.com");
}
if( isset($_POST['bic']) && strlen($_POST['bic']) > 0 )
{
	$params['bic'] = $_POST['bic'];
}

$address = array('company' => $_POST['company'], 'street' => $_POST['street'], 'code' => $_POST['code'], 'city' => $_POST['city'], 'country' => $_POST['country']);
$params['address'] = json_encode($address);

api::send('self/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/billing/update');

?>