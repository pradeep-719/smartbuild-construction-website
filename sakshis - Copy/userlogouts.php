<?php
session_start();

// ✅ Destroy all session data
session_unset();
session_destroy();

// ✅ Redirect user to home page
header("Location: home.php");
exit();
?>
