<?php

require_once("main.php");

$invalid = false;
if (!$_POST['enter_email']) $invalid = true;
if (!$_POST['retype_email']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

if ($_POST['enter_email'] != $_POST['retype_email']) {
	header('Location: sign_up_1.php?m=email_match');
	exit; 
}

try {
	$email = $_POST['retype_email'];
	$sql = get_db()->prepare("SELECT user FROM users WHERE user = ?");
	$sql->bindValue(1, $email);
	$sql->execute();
	$row = $sql->fetch();
} catch(PDOException $e) {
	die($e->getMessage());
}

if ($row) {
	header('Location: sign_up_1.php?m=user_exists');
	exit; 
}

session_start();
$token = MD5(openssl_random_pseudo_bytes(16));
$_SESSION['token'] = password_hash($email.$token, PASSWORD_DEFAULT);
$message = 'Please click the following link to continue setting up your account:';
$link = 'http://'.$_SERVER['HTTP_HOST'].'/sign_up_3.php?email='.urlencode($email).'&token='.$token;
mail($email, 'Registration Link', $message."\n\n".$link, 'From: '.$site_title.' <'.$email_from.'>');
header('Location: index.php?m=sent_reg');
