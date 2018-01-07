<?php // main.php -- Global variables and functions.

// Set the title of the site and the email return address.
$site_title = "PHP User Login";
$email_from = "noreply@example.com";

// Create a new database connection object and return it.
function get_db() {
	$db = new PDO('sqlite:users.db');
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

// Return all the data about one particular user.
function get_user_data($user) {
	$sql = get_db()->prepare("SELECT * FROM users WHERE user = ?");
	$sql->bindValue(1, $user);
	$sql->execute();
	$row = $sql->fetch();
	return $row;
}

// Display an alert message based on a short code.
function alert($code) {
	echo "<p>";
	echo "<em>";
	echo "Message: ";
	switch ($code) {
		case 'signed_in': echo 'Signed in successfully.'; break;
		case 'signed_out': echo 'You have been signed out.'; break;
		case 'deleted': echo 'Your user account has been deleted.'; break;
		case 'userpass_error': echo 'Incorrect username or password.'; break;
		case 'email_match': echo 'The entered emails do not match.'; break;
		case 'new_pass': echo 'Your password has been changed.'; break;
		case 'pass_match': echo 'The entered passwords do not match.'; break;
		case 'bad_pass': echo 'New password is too short or too long.'; break;
		case 'user_exists': echo 'The username you entered is unavailable.'; break;
		case 'user_error': echo 'No user exists with that name.'; break;
		case 'user_created': echo 'New user account created successfully.'; break;
		case 'sent_reg': echo 'Registration link sent, check your email.'; break;
		case 'sent_reset': echo 'Reset password link sent, check your email.'; break;
		case 'token_error': echo 'Invalid email address or session token.'; break;
		case 'token_expired': echo 'Your session token has expired.'; break;
		case 'not_deleted': echo 'Delete confirmation was incorrect.'; break;
		default: echo 'Unknown message code.'; break;
	}
	echo "</em>";
	echo "</p>";
}
