<?php
/* 
    ---------------
    getProductMessage()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, retrieves messages from productMessages table using user email 
    - Returns mysqli_result of query
    */
function getProductMessage($conn)
{
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        $sql = "SELECT * FROM productchat WHERE buyerEmail= '$userEmail' OR sellerEmail= '$userEmail'";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
}

function getIssueMessages($conn)
{
    // make sure the user is logged in, otherwise redirect to login page
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        // execute stored procedure
        $sql = "SELECT * FROM issue WHERE clientEmail='$userEmail'";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
}

function getProductDetail($conn, $productId)
{
    // execute stored procedure
    $sql = "CALL getProductInfo('$productId');";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function getUserDetail($conn, $userEmail)
{
    $sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
