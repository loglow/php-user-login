<?php // index.php -- Default site index.

// If the user is signed in, go to the private index, otherwise go to the login page. Pass on a message too, if one exists.
@session_start();
if (isset($_SESSION['user'])) {
	$url = 'index_private.php';
	if (isset($_GET['m'])) $url .= '?m='.$_GET['m'];
} else {
	$url = 'sign_in.php';
	if (isset($_GET['m'])) $url .= '?m='.$_GET['m'];
}
header('Location: '.$url);
