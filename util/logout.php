<?PHP
// start session
session_start();
// destroy session
session_destroy();
// direct back to login
header("Location: ../index.php");
?>