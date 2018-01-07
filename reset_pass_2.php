<?php // reset_pass_2.php -- Process the initial password reset request.

require_once("main.php");

// Verify that the request contains email address data.
$invalid = false;
if (!$_POST['enter_email']) $invalid = true;
if (!$_POST['retype_email']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// If the email address vars don't match, display an error message.
if ($_POST['enter_email'] != $_POST['retype_email']) {
	header('Location: reset_pass_1.php?m=email_match');
	exit;
}

// Connect to the users database and see if a the user in question exists.
try {
	$email = $_POST['retype_email'];
	$sql = get_db()->prepare("SELECT user FROM users WHERE user = ?");
	$sql->bindValue(1, $email);
	$sql->execute();
	$row = $sql->fetch();
} catch(PDOException $e) {
	die($e->getMessage());
}

// If the user doesn't exist, display an error message.
if (!$row) {
	header('Location: reset_pass_1.php?m=user_error');
	exit;
}

// If the user exists, start a session and generate a random token. Email a link with the token to the user, then display a confirmation message.
session_start();
$token = MD5(openssl_random_pseudo_bytes(16));
$_SESSION['token'] = password_hash($email.$token, PASSWORD_DEFAULT);
$message = 'Please click the following link to reset your account password:';
$link = 'http://'.$_SERVER['HTTP_HOST'].'/reset_pass_3.php?email='.urlencode($email).'&token='.$token;
mail($email, 'Reset Password Link', $message."\n\n".$link, 'From: '.$site_title.' <'.$email_from.'>');
header('Location: reset_pass_1.php?m=sent_reset');
