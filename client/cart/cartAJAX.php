<?php


include('../../util/db-config.php');
require_once('cart-utility.php');
session_start();


if (isset($_POST['deleteId'])) {
    $userEmail = $_SESSION['userEmail'];
    $deleteId = $_POST['deleteId'];
    $sql = "DELETE FROM CartItems WHERE productId= '$deleteId' AND userEmail='$userEmail'";
    $conn->query($sql);
    echo $sql." | ".$conn->error;
}