<?php
    if (isset($_POST['place_order'])) {
        session_start();
        require_once("../../util/db-config.php");
        $buyerEmail = $_SESSION['userEmail'];
        $productId = $_POST['place_order'];

        $sql = "SELECT userEmail, productPrice FROM Product WHERE productId='$productId';";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        echo $conn->error;
        
        $sellerEmail = $row['userEmail'];
        $orderTotal = $row['productPrice'];
        $orderDiscount = "0.0";
        $orderShipAddress = $_POST['address'];
        $orderShipCity = $_POST['city'];
        $orderShipState = $_POST['state'];
        $orderShipZip = $_POST['zip-code'];

        $conn->next_result();
        $sql = "CALL performTransaction('$buyerEmail', '$sellerEmail', '$productId', '$orderTotal', '$orderDiscount', '$orderShipAddress', '$orderShipCity', '$orderShipState', '$orderShipZip');";
        $conn->query($sql);
        echo $conn->error;

        header("Location: ../cart/cart.php");
    }
?>