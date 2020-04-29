<?php
//index.php
// session_start();

// The JSON standard MIME header. Output as JSON, not HTML
// header('Content-type: application/json');


include('../../util/db-config.php');
require_once('message-utility.php');

// include('inventoryManagementLib.php');

// if(!isset($_SESSION["type"]))
// {
//  header("location:login.php");
// }


if (isset($_POST['issueId'])) {


    $output = '';
    $issueId = $_POST['issueId'];
    $sql = "SELECT * FROM AdminMessages WHERE issueId= '$issueId'";
    $result = $conn->query($sql);

    $output .= '  
        <div class="container">';
    while ($thisRow = mysqli_fetch_assoc($result)) {
        $userResult = getUserDetail($conn, $thisRow['clientEmail']);
        $userDetail = $userResult->fetch_assoc();
        // $messageArray[] = $thisRow;
        $output .= '  
        <div class="row">  
        <h5>' . $userDetail["userFName"]. ' '. $userDetail["userLName"] .'</h5><p style="margin-left: 75%;">' . $thisRow["messageTime"] . '</p>
        </div>
        <p>' . $thisRow["messageText"] . '</p>
        <hr />

        ';
    }
    $output .= '
        <div class="container">

            <div class="row">
                <textarea name="messageText" id="messageText" class="form-control" rows="3" placeholder="Enter your message here"></textarea>
                <input type="hidden" name="hdnMessage" class="issueId" value="' . $issueId . '" id="issueId" />
                <button type="submit" name="issueMessage" value="' . $issueId . '" class="btn btn-success" id="sendMessage">Send</button>
            </div>
        </div>
    </div>';

    echo $output;

    // echo json_encode($messageArray);
}
