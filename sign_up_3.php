<?php // sign_up_3.php -- Process and respond to an emailed account registration link.

require_once("main.php");

// Make sure the request contains an email address and token, otherwise redirect to index.
$invalid = false;
if (!$_GET['email']) $invalid = true;
if (!$_GET['token']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Make sure that a session token actually exists, otherwise go to index with an error.
session_start();
if (!$_SESSION['token']) {
	header('Location: index.php?m=token_expired');
	exit;
}

// Check to see if the provided token matches the session token. If they don't match, error.
if (!password_verify($_GET['email'].$_GET['token'], $_SESSION['token'])) {
	header('Location: index.php?m=token_error');
	exit;
}

require('header.php');

// The tokens match, so display a form for the new user to create a password.
?>

<form action="sign_up_4.php" method="post">
	<fieldset>
		<legend>Create your new account</legend>
		<input type="hidden" name="email" value="<?=$_GET['email']?>">
		<input type="hidden" name="token" value="<?=$_GET['token']?>">
		<p>Your new password must contain between 8 and 64 characters.</p>
		<p><input type="password" name="new_pass" placeholder="New password" required></p>
		<p><input type="password" name="repeat_pass" placeholder="Retype new password" required></p>
		<p>
			<button type="submit">Create account</button>
			<button type="reset">Clear</button>
		</p>
	</fieldset>
</form>

<?php

require('footer.php');
