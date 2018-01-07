<?php

require_once("main.php");

session_start();
$invalid = false;
if (!$_SESSION['user']) $invalid = true;
if (!$_POST['new_pass']) $invalid = true;
if (!$_POST['repeat_pass']) $invalid = true;
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

try {
	$sql = get_db()->prepare("UPDATE users SET pass = ? WHERE user = ?");
	$sql->bindValue(1, password_hash($_POST['repeat_pass'], PASSWORD_DEFAULT));
	$sql->bindValue(2, $_SESSION['user']);
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

header('Location: index.php?m=new_pass');
