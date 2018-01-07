<?php // index_private.php -- Default landing page when a user is signed in.

require_once("main.php");

require('header.php');

// Load all info about this user from the database
$user = get_user_data($_SESSION['user']);

// Display user info, then options to change password, delete account, or sign out.
?>

<dl>
	<dt>Your user info:</dt>
	<dd>User ID: <?=$user['uid']?></dd>
	<dd>Username: <?=$user['user']?></dd>
	<dd>Hashed password: <?=$user['pass']?></dd>
</dl>
<p>
	<form action="new_pass.php" method="post">
		<fieldset>
			<legend>Change your password</legend>
			<p>Your new password must contain between 8 and 64 characters.</p>
			<p><input type="password" name="new_pass" placeholder="New password" required></p>
			<p><input type="password" name="repeat_pass" placeholder="Retype new password" required></p>
			<p>
				<button type="submit">Change password</button>
				<button type="reset">Clear</button>
			</p>
		</fieldset>
	</form>
</p>
<p>
	<form action="delete.php" method="post">
		<fieldset>
			<legend>Delete your account</legend>
			<p>Type the word <code>delete</code> in the box below to confirm.</p>
			<p><input type="text" name="confirm" placeholder="Confirm" required></p>
			<p>
				<button type="submit">Delete account</button>
				<button type="reset">Clear</button>
			</p>
		</fieldset>
	</form>
</p>
<p><a href="sign_out.php">Sign out</a></p>

<?php

require('footer.php');
