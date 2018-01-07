<?php // reset_pass_3.php -- Process and respond to an emailed reset passwork link.

require_once("main.php");

// Verify that the request includes the email address and a token, otherwise redirect.
$invalid = false;
if (!$_GET['email']) $invalid = true;
if (!$_GET['token']) $invalid = true;
if ($invalid) {
	header('Location: index.php');
	exit;
}

// Make sure that the current session still contains the previously generated random token.
session_start();
if (!$_SESSION['token']) {
	header('Location: index.php?m=token_expired');
	exit;
}

// Check that the new token matches the existing token, otherwise error.
if (!password_verify($_GET['email'].$_GET['token'], $_SESSION['token'])) {
	header('Location: index.php?m=token_error');
	exit;
}

require('header.php');

// The tokens match, so display a form for the account password to be reset.
?>

<form action="reset_pass_4.php" method="post">
	<fieldset>
		<legend>Reset your password</legend>
		<input type="hidden" name="email" value="<?=$_GET['email']?>">
		<input type="hidden" name="token" value="<?=$_GET['token']?>">
		<p>Your new password must contain between 8 and 64 characters.</p>
		<p><input type="password" name="new_pass" placeholder="New password" required></p>
		<p><input type="password" name="repeat_pass" placeholder="Retype new password" required></p>
		<p>
			<button type="submit">Reset password</button>
			<button type="reset">Clear</button>
		</p>
	</fieldset>
</form>

<?php

require('footer.php');
