<?php // sign_in.php -- Page for the user to enter their credentials.

require_once("main.php");

require('header.php');

// Display a form for the user to enter their username and password. Also provide password reset and sign up links.
?>

<form action="auth.php" method="post">
	<fieldset>
		<legend>User login</legend>
		<p>Please authenticate to continue.</p>
		<p><input type="email" name="user" placeholder="Email" required></p>
		<p><input type="password" name="pass" placeholder="Password" required></p>
		<p>
			<button type="submit">Sign in</button>
			<button type="reset">Clear</button>
		</p>
	</fieldset>
</form>
<p><a href="reset_pass_1.php">Reset password</a></p>
<p><a href="sign_up_1.php">Sign up</a></p>

<?php

require('footer.php');
