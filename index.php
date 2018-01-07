<?php

@session_start();
if (isset($_SESSION['user'])) {
	$url = 'index_private.php';
	if (isset($_GET['m'])) $url .= '?m='.$_GET['m'];
} else {
	$url = 'sign_in.php';
	if (isset($_GET['m'])) $url .= '?m='.$_GET['m'];
}
header('Location: '.$url);
