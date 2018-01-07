<?php

$public = [
	'sign_in',
	'sign_up_1',
	'sign_up_3',
	'reset_pass_1',
	'reset_pass_3',
];

@session_start();
if (!isset($_SESSION['user'])) {
	$continue = false;
	$base = basename($_SERVER['PHP_SELF']);
	foreach ($public as $page) {
		if ($base == $page.'.php') $continue = true;
	}
	if (!$continue) {
		header("Location: index.php");
		exit; 
	}
}

?><!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$site_title?></title>
</head>
<body>
<p><a href="index.php"><?=$site_title?></a></p>

<?php

if (isset($_GET['m'])) {
	alert($_GET['m']);
}