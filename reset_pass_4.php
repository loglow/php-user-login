<?php // reset_pass_4.php -- Process the final password reset request.

require_once("main.php");

// Make sure the email address and token are part of the request, and that the session token exists too.
session_start();
$invalid = false;
if (!$_SESSION['token']) $invalid = true;
if (!$_POST['email']) $invalid = true;
if (!$_POST['token']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Make sure the new password uses valid chars and is the correct length, otherwise go back to form with error.
if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['new_pass'])) $invalid = true;
if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['repeat_pass'])) $invalid = true;
if ($invalid) {
	header('Location: reset_pass_3.php?m=bad_pass&email='.$_POST['email'].'&token='.$_POST['token']);
	exit;
}

// Make sure the two password vars actually match, and if not, go back to form with error.
if ($_POST['new_pass'] !== $_POST['repeat_pass']) {
	header('Location: reset_pass_3.php?m=pass_match&email='.$_POST['email'].'&token='.$_POST['token']);
	exit;
}

// Check again to make sure the emailed token matches the session token. If not, redirect to index.
if (!password_verify($_POST['email'].$_POST['token'], $_SESSION['token'])) {
	header('Location: index.php?m=token_error');
	exit;
}

// Kill the session token before database access.
session_unset();
session_destroy();

// Connect to the users database and store the new hashed password.
try {
	$sql = get_db()->prepare("UPDATE users SET pass = ? WHERE user = ?");
	$sql->bindValue(1, password_hash($_POST['repeat_pass'], PASSWORD_DEFAULT));
	$sql->bindValue(2, $_POST['email']);
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

// Return to the index with a success message.
header('Location: index.php?m=new_pass');
