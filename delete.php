<?php // delete.php -- Delete a user account.

require_once("main.php");

// Verify that the user is currently signed in, otherwise redirect to index.
session_start();
if (!$_SESSION['user']) {
	header('Location: index.php');
	exit;
}

// Verify that the user confirmed deletion by typing 'delete' before request.
if ($_POST['confirm'] != 'delete') {
	header('Location: index.php?m=not_deleted');
	exit;
}

// Connect to the users database and delete the current user account.
try {
	$sql = get_db()->prepare("DELETE FROM users WHERE user = ?");
	$sql->bindValue(1, $_SESSION['user']);
	$sql->execute();
} catch(PDOException $e) {
	die($e->getMessage());
}

// Delete the current session and redirect with a confirmation message.
session_unset();
session_destroy();
header('Location: index.php?m=deleted');
