<!-- <?php
// ini_set('display_errors', E_ALL);

// //index.php
// include('../db-config.php');
// include('../config.html');
// // include('inventoryManagementLib.php');

// // if(!isset($_SESSION["type"]))
// // {
// //  header("location:login.php");
// // }

// if (array_key_exists('hdnMessage', $_POST)) {
//     if (isset($_POST['submit'])) {
//         $userEmail = $_SESSION['userEmail'];
//         $messageText = $_POST['messageText'];
//         $sql = "INSERT INTO chatmessages (userEmail, messageText, messageSentTime) VALUES('$userEmail', '$messageText', CURRENT_TIMESTAMP)";
//         $result = $conn->query($sql);
//         echo $result;
//     }
// }

// if (isset($_GET['chatDetail'])) {
//     //clean it up
//     if (!is_numeric($_GET['chatDetail'])) {
//         //Non numeric value entered. Someone tampered with the bookid
//         $error = true;
//         $errormsg = " Security, Serious error. Contact webmaster: productId enter: " . $_GET['chatDetail'] . "";
//     } else {
//         //book_id is numeric number
//         //clean it up
//         $chatId = mysqli_real_escape_string($conn, $_GET['chatDetail']);
//         $sql = "SELECT * FROM chatmessages WHERE chatId='$chatId'";
//         $result = $conn->query($sql);
//         // $conn->next_result(); // allow next query to execute

//     }
// }

            // include('header.php');
?>
            <script>
    function showMessages() {
        var messagesList = document.getElementById("messagesList");
        var chatId = document.getElementById("chatId").value;

        var httpReq = new XMLHttpRequest();

        // Add AJAX call
        // Request the API script using POST, calling the PHP script
        httpReq.open("POST", "../util/messages/messageAJAX.php?chatDetail="+ chatId, true);
        httpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        httpReq.onreadystatechange = function() {
            if (httpReq.readyState == 4 && httpReq.status == 200) {
                console.log(httpReq.responseText);
                var dataObject = JSON.parse(httpReq.responseText);
                messagesList.innerHTML = "";

                var stringToDisplay = "";
                stringToDisplay += "<div class='container'>";

                // Clear the data each time around
                for (var index in dataObject) {
                    stringToDisplay += "<div class='row'>";

                    stringToDisplay += "<h4>" + dataObject[index].userEmail + "</h4>" + "<p style='margin-left: 75%;'>" + dataObject[index].messageSentTime + "</p>";
                    stringToDisplay += "</div>";

                    stringToDisplay += "<p>" + dataObject[index].messageText + "</p>";
                    stringToDisplay += "<hr />";

                } // end of for( )
                stringToDisplay += "</div>";

                // Display the String containing the HTML table output as the text of the #result <div>.
                messagesList.innerHTML = stringToDisplay;
            } // end of if readyState
        } // end of onreadystatechange

        // Send the request with a POST variable of product
        httpReq.send("messageAJAX");
        messagesList.innerHTML = "<br />Requesting data from server...";
        // Twiddle the CPU's thumbs for 4 seconds
        // Then, call the function.
    } // end of showMessages( )
</script>

            <head>
                <title>messageDetail.php</title>
            </head>

            <body>
                <input type="hidden" value="" id="chatId">

                <div id="messagesList"></div>

    <script>
        setTimeout(showMessages(), 10);
    </script>
                <div class="container">
               
        <div class="row">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <textarea name="messageText" id="" cols="30" rows="10" placeholder="Enter your message here"></textarea>
                <input type='hidden' name='hdnMessage' value='returning' />
                <button type="submit" name="submit">Send</button>
            </form>
        </div>
                </div>
            </body>



             -->