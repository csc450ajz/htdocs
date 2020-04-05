<?php


include('../../util/db-config.php');
require_once('message-utility.php');
session_start();
// if(!isset($_SESSION["type"]))
// {
//  header("location:login.php");
// }


if (isset($_POST['chatId'])) {

    
    $output = '';
    $chatId = $_POST['chatId'];
    $sql = "SELECT * FROM chatmessages WHERE chatId= '$chatId' ";
    $result = $conn->query($sql);


    $output .= '  
        <div class="container">';
    while ($thisRow = mysqli_fetch_assoc($result)) {
        // $messageArray[] = $thisRow;
        $userResult = getUserDetail($conn, $thisRow['userEmail']);
        $userDetail = $userResult->fetch_assoc();

        $output .= '  
        <div class="row">  
        <h4>'. $userDetail["userFName"]. ' '. $userDetail["userLName"] .'</h4><p style="margin-left: 75%;">' . $thisRow["messageSentTime"] . '</p>
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

// if (isset($_POST['issueId'])) {

    
//     $output = '';
//     $issueId = $_POST['issueId'];
//     $userEmail = $_SESSION['userEmail'];
//     $sql = "SELECT * FROM adminmessages WHERE issueId= '$issueId'";
//     $result = $conn->query($sql);


//     $output .= '  
//         <div class="container">';
//     while ($thisRow = mysqli_fetch_assoc($result)) {
//         // $messageArray[] = $thisRow;
//         $userResult = getUserDetail($conn, $thisRow['clientEmail']);
//         $userDetail = $userResult->fetch_assoc();

//         $output .= '  
//         <div class="row">  
//         <h4>'. $userDetail["userFName"]. ' '. $userDetail["userLName"] .'</h4><p style="margin-left: 75%;">' . $thisRow["messageSentTime"] . '</p>
//         </div>
//         <p>' . $thisRow["messageText"] . '</p>
//         <hr />

//         ';
//     }
//     $output .= '
//         <div class="container">

//             <div class="row">
//                 <textarea name="messageText" id="messageText" class="form-control" rows="3" placeholder="Enter your message here"></textarea>
//                 <input type="hidden" name="hdnMessage" class="issueId" value="' . $issueId . '" id="issueId" />
//                 <input type="hidden" name="hdnMessage" class="userEmail" value="' . $userEmail . '" id="userEmail" />
//                 <button type="submit" name="issueMessage" value="' . $issueId . '" class="btn btn-success" id="sendMessage">Send</button>
//             </div>
//         </div>
//     </div>';

//     echo $output;

//     // echo json_encode($messageArray);
// }
