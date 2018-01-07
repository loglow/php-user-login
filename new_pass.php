<?php // new_pass.php -- Process a password change request from a signed in user.

require_once("main.php");

// Verify the user is signed in and the request contains new password data.
session_start();
$invalid = false;
if (!$_SESSION['user']) $invalid = true;
if (!$_POST['new_pass']) $invalid = true;
if (!$_POST['repeat_pass']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Check that the new password is valid chars and length. If not, redirect with error message.
if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['new_pass'])) $invalid = true;
if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['repeat_pass'])) $invalid = true;
if ($invalid) {
	header('Location: index.php?m=bad_pass');
	exit;
}

// Check that the new password vars match. If not, redirect with error message.
if ($_POST['new_pass'] !== $_POST['repeat_pass']) {
	header('Location: index.php?m=pass_match');
	exit;
}

// Connect to the users database and update the password for the current user.
try {
	$sql = get_db()->prepare("UPDATE users SET pass = ? WHERE user = ?");
	$sql->bindValue(1, password_hash($_POST['repeat_pass'], PASSWORD_DEFAULT));
	$sql->bindValue(2, $_SESSION['user']);
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

// Redirect with a success message.
header('Location: index.php?m=new_pass');
