<?php
// if user is already logged in, redirect to profile page
include('util/check-login.php');
if (checkAdmin()) {
    header('Location: admin/admin.php');
} else if (checkClient()) {
    header('Location: admin/admin.php');
} 

// create db connection 
include('util/db-config.php');

$message = '';
if (isset($_POST["login"])) {
    $sql = "SELECT * FROM User WHERE userEmail=?";
    //set up a prepared statement
    $rowCount;
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
        
        // bind results to variables
        $stmt->bind_result($userEmail, $userFName, $userLName, $userType, $userPassword, $addressID, $userBalance, $userPhotoPath);
        $stmt->fetch();

        // Free results
        $stmt->free_result();

        // Close the statement
        $stmt->close();
    } // end if( prepare( ))

    if ($rowCount > 0) {     
        if ($_POST["user_password"]==$userPassword) {
            // set session variables
            $_SESSION['type'] = $userType;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userName'] = $userFName;
            // log the results to console for DEBUG
            console_log("Successful Login! | Username: $userEmail | Password: $userPassword");
            if($_SESSION['type']=="admin") {
                header("Location: admin/admin.php");
            }else{
                //header("Location: index.php"); // TODO -- Update to client page when created.
            }
        } else {
            $message = "<label>Wrong username or password</label>";
        }
    } else {
        console_log("Unsuccessful login.");
        $message = "<label>Wrong username or password</label>";
    }
}

function console_log($message) {
    echo "<script>console.log('$message');</script>"; 
}

?>

<!DOCTYPE html>
<html>
<?php
require_once('util/config.html')
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