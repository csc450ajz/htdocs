<?php 
session_start();
require_once('db-config.php');

if (isset($_POST['updateUserBalance'])) {
    $userEmail = $_SESSION['userEmail'];
    $newReward = $_POST['newReward'];

    $userResult= getUserDetail($conn, $userEmail);
    $row = mysqli_fetch_assoc($userResult);

    $userBalance = $row['userBalance'];

    //Set New Balance
    $newBalance = $newReward + $userBalance;

    //Update User Balance
    $conn->next_result();
    $updateResult = updateUserBalance($conn, $userEmail, $newBalance);
    $row = mysqli_fetch_assoc($updateResult);
    echo $row;
}

if (isset($_POST['userBalance'])) {
    $userEmail = $_SESSION['userEmail'];
    $userResult = getUserDetail($conn, $userEmail);
    $row = mysqli_fetch_assoc($userResult);
    echo $row['userBalance'];
}

//Function for updating user balance with new balance
function updateUserBalance($conn, $userEmail, $newBalance)
{
    $sql = "UPDATE User SET userBalance='$newBalance' WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

//Function for getting user info
function getUserDetail($conn, $userEmail)
{
    $sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

?>