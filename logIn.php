<!-- logIn.php - login page for user's
      
    -->
<?php
// require_once('config.html')
?>

<?php
//login.php

include('databaseConnection.php');

// if (isset($_SESSION['userEmail'])) {
//     header("Location: index.php");
// }

$message = '';

if (isset($_POST["login"])) {
    $sql = "SELECT * FROM user WHERE userEmail=?";
    //set up a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        //pass parameters
        $stmt->bind_param("s", $_POST["user_email"]);
        if ($stmt->errno) {
            echo "Statement prapare has error";
        }

        // execute
        $stmt->execute();
        if ($stmt->errno) {
            echo "Could not execute prepared statment";
        }

        $stmt->store_result();
        $rowCount = $stmt->num_rows;

        $stmt->bind_result($userEmail, $userFName, $userLName, $userType, $userPassword, $addressID, $userBalance, $userPhotoPath);
        $stmt->fetch();

        // Free results
        $stmt->free_result();

        // Close the statement
        $stmt->close();
    } // end if( prepare( ))

    if ($rowCount > 0) {
        
        if ($_POST["user_password"]==$userPassword) {
            $_SESSION['type'] = $userType;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userName'] = $userFName;
            if($_SESSION['type']=="admin") {
                header("Location: admin.php");
            }else{
                header("Location: index.php");
            }
        } else {
            $message = "<label>Wrong Password</label>";
        }
    } else {
        $message = "<label>Wrong Email Address</labe>";
    }
}

?>

<!DOCTYPE html>
<html>
<?php
require_once('config.html')
?>

<head>
    <title>SporTrader Login</title>
</head>

<body>
    <br />
    <div class="container" style="max-width: 500px; margin: auto;">
        <!-- <h2 align="center">SporTraders</h2> -->
        <img src="images/logo.png" alt="Company Logo" style="border-radius: 50%; display: block; margin: auto; width: 50%;">
        <br />
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="post">
                    <?php echo $message; ?>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="user_email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-success" />
                        <input type="submit" name="signup" value="Signup" class="btn btn-primary" style="float: right;"/>
                    </div>


                    <!-- <div>
                        <label for=""></label>
                    </div> -->
                </form>

            </div>
        </div>
    </div>


</body>

</html>