<?php

require_once("main.php");

require('header.php');

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
