<?php // sign_up_1.php -- Page to initiate the creation of a new account.

require_once("main.php");

require('header.php');

// Display a form for the user to input their email address and verify it.
?>

<form action="sign_up_2.php" method="post">
	<fieldset>
		<legend>Sign up</legend>
		<p>A registration link will be sent to your email address.</p>
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
