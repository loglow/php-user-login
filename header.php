<?php // header.php -- Content inserted at top of pages.

// List of pages that can be accessed without being signed in.
$public = [
	'sign_in',
	'sign_up_1',
	'sign_up_3',
	'reset_pass_1',
	'reset_pass_3',
];

// See if the user is signed in. If not, see if this is a public page. If not, redirect to index.
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

// Beginning of HTML document
?><!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$site_title?></title>
</head>
<body>
<p><a href="index.php"><?=$site_title?></a></p>

<?php

// If a message is indicated as part of the URL, display an alert.
if (isset($_GET['m'])) {
	alert($_GET['m']);
}