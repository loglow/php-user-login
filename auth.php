<?php

require_once("main.php");

$invalid = false;
if (!$_POST['user']) $invalid = true;
if (!$_POST['pass']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

try {
	$sql = get_db()->prepare("SELECT pass FROM users WHERE user = ?");
	$sql->bindValue(1, $_POST['user']);
	$sql->execute();
	$row = $sql->fetch();
} catch(PDOException $e) {
	die($e->getMessage());
}

if (!$row || !password_verify($_POST['pass'], $row['pass'])) {
	header('Location: index.php?m=userpass_error');
	exit;
}
session_start();
$_SESSION['user'] = $_POST['user'];
header('Location: index.php?m=signed_in');
