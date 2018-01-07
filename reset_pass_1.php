<?php // reset_pass_1.php -- Page to initiate a password reset.

require_once("main.php");

require('header.php');

// Display a form for the user to enter their email address and verify it.
?>

<form action="reset_pass_2.php" method="post">
	<fieldset>
		<legend>Reset your password</legend>
		<p>A password reset link will be sent to your email address.</p>
		<p><input type="email" name="enter_email" placeholder="Enter email" required></p>
		<p><input type="email" name="retype_email" placeholder="Retype email" required></p>
		<p>
			<button type="submit">Send email</button>
			<button type="reset">Clear</button>
		</p>
	</fieldset>
</form>

<?php

require('footer.php');
