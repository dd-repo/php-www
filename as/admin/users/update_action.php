<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
	throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");

$params = array('user'=>$_POST['id']);
if( isset($_POST['email']) && strlen($_POST['email']) > 0 )
	$params['email'] = $_POST['email'];
if( isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 )
	$params['firstname'] = $_POST['firstname'];
if( isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 )
	$params['lastname'] = $_POST['lastname'];
if( isset($_POST['pass']) && strlen($_POST['pass']) > 0 )
	$params['pass'] = $_POST['pass'];
if( isset($_POST['postal_address']) && strlen($_POST['postal_address']) > 0 )
	$params['postal_address'] = $_POST['postal_address'];
if( isset($_POST['postal_code']) && strlen($_POST['postal_code']) > 0 )
	$params['postal_code'] = $_POST['postal_code'];
if( isset($_POST['organisation']) && strlen($_POST['organisation']) > 0 )
	$params['organisation'] = $_POST['organisation'];
if( isset($_POST['locality']) && strlen($_POST['locality']) > 0 )
	$params['locality'] = $_POST['locality'];
	
$params['billing'] = $_POST['billing'];

api::send('user/update', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id=' . $_POST['id']);

?>
