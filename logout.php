<?php
session_start();

// Destroy session and redirect to landing page
session_unset();
session_destroy();
header("Location: landing.php");
exit;
?>
