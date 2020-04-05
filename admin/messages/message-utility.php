<?php
//index.php
session_start();

// The JSON standard MIME header. Output as JSON, not HTML
// header('Content-type: application/json');


// include('../db-config.php');
// include('inventoryManagementLib.php');

// if(!isset($_SESSION["type"]))
// {
//  header("location:login.php");
// }




/*
    This page defines a series of cart functions, 
    such as adding an item to the cart or removing
    an item from the cart

    Developer: Please be sure to pass in a mysqli
    connection object ($conn) into any function
    call, as this ensures there are not duplicate
    connection objects.
    */


/* 
    ---------------
    getProductMessage()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, retrieves messages from productMessages table using user email 
    - Returns mysqli_result of query
    */
function getIssueMessages($conn)
{
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        // execute stored procedure
        $sql = "SELECT * FROM issue";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
}

function getUserDetail($conn, $userEmail)
{
    $sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
