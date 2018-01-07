<?php

require_once("main.php");

session_start();
$invalid = false;
if (!$_SESSION['user']) {
	header('Location: index.php');
	exit;
}

if ($_POST['confirm'] != 'delete') {
	header('Location: index.php?m=not_deleted');
	exit;
}

try {
	$sql = get_db()->prepare("DELETE FROM users WHERE user = ?");
	$sql->bindValue(1, $_SESSION['user']);
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

session_unset();
session_destroy();
header('Location: index.php?m=deleted');
