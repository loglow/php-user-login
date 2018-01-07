<?php // auth.php -- Authenticate a login attempt.

require_once("main.php");

// If request does not include the username and password, redirect to the index page.
$invalid = false;
if (!$_POST['user']) $invalid = true;
if (!$_POST['pass']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Attempt to connect to the users database and get the user's hashed password.
try {
	$sql = get_db()->prepare("SELECT pass FROM users WHERE user = ?");
	$sql->bindValue(1, $_POST['user']);
	$sql->execute();
	$row = $sql->fetch();
} catch(PDOException $e) {
	die($e->getMessage());
}

// Redirect with an error if the user doesn't exist or the password is wrong.
if (!$row || !password_verify($_POST['pass'], $row['pass'])) {
	header('Location: index.php?m=userpass_error');
	exit;
}

// The user exists and the password is correct. Start the session, then redirect with success message.
session_start();
$_SESSION['user'] = $_POST['user'];
header('Location: index.php?m=signed_in');
