<?php // sign_out.php -- Process a user logout request.

// It doesn't actually matter if a user is signed in or not. Just kill the session, then redirect with a message.
session_start();
session_unset();
session_destroy();
header("Location: index.php?m=signed_out");
