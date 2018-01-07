<?php

require_once("main.php");

session_start();
$invalid = false;
if (!$_SESSION['token']) $invalid = true;
if (!$_POST['email']) $invalid = true;
if (!$_POST['token']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['new_pass'])) $invalid = true;
if (!preg_match("/^[\x20-\x7E]{8,64}$/", $_POST['repeat_pass'])) $invalid = true;
if ($invalid) {
	header('Location: index.php?m=bad_pass');
	exit;
}

if ($_POST['new_pass'] !== $_POST['repeat_pass']) {
	header('Location: index.php?m=pass_match');
	exit;
}

if (!password_verify($_POST['email'].$_POST['token'], $_SESSION['token'])) {
	header('Location: index.php?m=token_error');
	exit;
}

session_unset();
session_destroy();

try {
	$sql = get_db()->prepare("INSERT INTO users (user, pass) VALUES (?, ?)");
	$sql->bindValue(1, $_POST['email']);
	$sql->bindValue(2, password_hash($_POST['repeat_pass'], PASSWORD_DEFAULT));
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

header('Location: index.php?m=user_created');
