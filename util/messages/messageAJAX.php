<?php
//index.php
// session_start();

// The JSON standard MIME header. Output as JSON, not HTML
// header('Content-type: application/json');


include('../db-config.php');
// include('inventoryManagementLib.php');

// if(!isset($_SESSION["type"]))
// {
//  header("location:login.php");
// }


if (isset($_POST['chatId'])) {

    // if productId is passed in POST, add to cart
    // require_once("util/cart-utility.php");
    // addProductMessage($_POST['productId'], $conn);

    // get navbar


    // call getFeaturedProducts() stored procedure
    // $sql = "CALL getProductMessages();";
    // senderEmail, recipientEmail, messageText, messageTime, messageStatus
    // $userEmail = $_SESSION['userEmail'];
    // $chatId = mysqli_real_escape_string($conn, $_POST['chatDetail']);
    $output = '';
    $chatId = $_POST['chatId'];
    $sql = "SELECT * FROM chatmessages WHERE chatId= '$chatId' ";
    $result = $conn->query($sql);

    // $result = $conn->query($sql);
    // displayResult($result, $sql);
    // echo ($result);
    // Loop through the $result to create JSON formatted data   
    // $messageArray = array();

    $output .= '  
        <div class="container">';
    while ($thisRow = mysqli_fetch_assoc($result)) {
        // $messageArray[] = $thisRow;
        $output .= '  
        <div class="row">  
        <h4>' . $thisRow["userEmail"] . '</h4><p style="margin-left: 75%;">' . $thisRow["messageSentTime"] . '</p>
        </div>
        <p>' . $thisRow["messageText"] . '</p>
        <hr />

        ';
    }
    $output .= '
        <div class="container">

            <div class="row">
                <textarea name="messageText" id="messageText" class="form-control" rows="3" placeholder="Enter your message here"></textarea>
                <input type="hidden" name="hdnMessage" class="chatId" value="' . $chatId . '" id="' . $chatId . '" />
                <button type="submit" name="productMessage" value="' . $chatId . '" class="btn btn-success" id="sendMessage">Send</button>
            </div>
        </div>
    </div>';

    echo $output;

    // echo json_encode($messageArray);
}
