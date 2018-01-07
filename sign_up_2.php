<?php // sign_up_2.php -- Process the initial account creation request.

require_once("main.php");

// Verify that the request actually contains the email address vars, otherwise redirect to index.
$invalid = false;
if (!$_POST['enter_email']) $invalid = true;
if (!$_POST['retype_email']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Make sure that both email address vars actually match, otherwise error.
if ($_POST['enter_email'] != $_POST['retype_email']) {
	header('Location: sign_up_1.php?m=email_match');
	exit; 
}

// If they match, connect to the database and see if a user with this address already exists.
try {
	$email = $_POST['retype_email'];
	$sql = get_db()->prepare("SELECT user FROM users WHERE user = ?");
	$sql->bindValue(1, $email);
	$sql->execute();
	$row = $sql->fetch();
} catch(PDOException $e) {
	die($e->getMessage());
}

// If a user already exists with this email, display an error.
if ($row) {
	header('Location: sign_up_1.php?m=user_exists');
	exit; 
}

// User doesn't already exist, so start a session and create a random token, then email them a link with it.
session_start();
$token = MD5(openssl_random_pseudo_bytes(16));
$_SESSION['token'] = password_hash($email.$token, PASSWORD_DEFAULT);
$message = 'Please click the following link to continue setting up your account:';
$link = 'http://'.$_SERVER['HTTP_HOST'].'/sign_up_3.php?email='.urlencode($email).'&token='.$token;
mail($email, 'Registration Link', $message."\n\n".$link, 'From: '.$site_title.' <'.$email_from.'>');
header('Location: index.php?m=sent_reg');
