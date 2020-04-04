<?php
//index.php

// The JSON standard MIME header. Output as JSON, not HTML
// header('Content-type: application/json');


// include('../db-config.php');
// include('inventoryManagementLib.php');

// if(!isset($_SESSION["type"]))
// {
//  header("location:login.php");
// }


if (isset($_POST['messageAJAX'])) {

    // if productId is passed in POST, add to cart
    // require_once("util/cart-utility.php");
    // addProductMessage($_POST['productId'], $conn);

    // get navbar


    // call getFeaturedProducts() stored procedure
    // $sql = "CALL getProductMessages();";
    // senderEmail, recipientEmail, messageText, messageTime, messageStatus
    // $userEmail = $_SESSION['userEmail'];
    // $sql = "SELECT * FROM chatmessages WHERE userEmail=$userEmail";

    // $result = $conn->query($sql);
    // // $result = $conn->query($sql);
    // // displayResult($result, $sql);
    // // echo ($result);
    // // Loop through the $result to create JSON formatted data   
    // $messageArray = array();
    // while ($thisRow = $result->fetch_assoc()) {
    //     $messageArray[] = $thisRow;
    // }
    // echo json_encode($messageArray);

    switch ($_POST['product']) {

        case 'new':
            addProductMessage($_POST['productId'], $conn);
            break;

        case 'delete':
            deleteChat($conn, $_POST['productId']);
            break;
    }
}


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
    addCartItem()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, stores productId in CartItems table with session userEmail
    */
function addProductMessage($itemId, $conn)
{
    session_start();
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        // get productId and userEmail
        $productId = $itemId;
        $userEmail = $_SESSION['userEmail'];

        // execute stored procedure
        $sql = "CALL insertCartItem('$productId', '$userEmail');";
        $cartResult = $conn->query($sql);
        $conn->next_result(); // allows following queries to occur
        echo $conn->error;
    } else {
        header("Location: /logIn.php");
        $_SESSION['redirect'] = '/index.php'; // setting this in case we implement a redirect on login page
    }
}
/* 
    ---------------
    getCartItems()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, gets all items in Cart at their email address 
    - Returns mysqli_result of query
    */
function getProductMessage($conn)
{
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        // execute stored procedure
        // $sql = "CALL getCartItems('$userEmail');";
        $sql = "SELECT * FROM productchat";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
}

/* 
    ---------------
    getCartItems()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, gets all items in Cart at their email address 
    - Returns mysqli_result of query
    */
function deleteChat($conn, $chatId)
{
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        // execute stored procedure
        $sql = "SELECT * FROM productchat WHERE buyerEmail=$userEmail OR sellerEmail=$userEmail";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
}
