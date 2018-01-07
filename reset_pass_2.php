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
	header('Location: reset_pass_1.php?m=email_match');
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

if (!$row) {
	header('Location: reset_pass_1.php?m=user_error');
	exit;
}

session_start();
$token = MD5(openssl_random_pseudo_bytes(16));
$_SESSION['token'] = password_hash($email.$token, PASSWORD_DEFAULT);
$message = 'Please click the following link to reset your account password:';
$link = 'http://'.$_SERVER['HTTP_HOST'].'/reset_pass_3.php?email='.urlencode($email).'&token='.$token;
mail($email, 'Reset Password Link', $message."\n\n".$link, 'From: '.$site_title.' <'.$email_from.'>');
header('Location: reset_pass_1.php?m=sent_reset');
