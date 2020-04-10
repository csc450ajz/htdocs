<?php 
require_once('db-config.php');
require_once('check-login.php');
if (checkLogin()) {
    $navbar = "/clientNavbar.php";
} else {
    $navbar = "/guestNavbar.php";
}
?>
