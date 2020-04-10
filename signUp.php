<?php
// if user is already logged in, redirect to profile page
include('util/check-login.php');
if (checkAdmin()) {
    header('Location: admin/admin.php');
} else if (checkClient()) {
    header('Location: client/client.php');
} 

// create db connection 
include('util/db-config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // gather information from POST array
    $userEmail = $_POST['email'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $userType = "client"; // all users created this way are clients
    $userPassword = $_POST['password'];
    // gather address info
    $streetAddress = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zip-code'];

    //check to make sure other users are not taken 
    $sql = ("SELECT * FROM User WHERE userEmail = $userEmail");
    $result = $conn->query($sql);

    if ($result) {
        echo "<div class='alert alert-danger' role='alert'>Username already taken!</div>";
    } else {
        // add images to file system
        require_once('util/image-util.php');
        $photoPath = storeProfileImage($_FILES['profilePic']);
        //call procedure (each new account for now starts with $50.00)
        $sql = "CALL createAccount('$userEmail', '$fName', '$lName', '$userType', '$userPassword', '50.0', '$streetAddress', '$state', '$zipCode', '$city', '$photoPath');";
        $conn->query($sql);
        echo $conn->error;

        // send to login page
        //header("Location: /logIn.php");
    }
} else {
    //echo "bummer";
}

?>

<!DOCTYPE html>
<html>
<?php
require_once('util/config.php');
?>

<head>
    <title>SporTrader Login</title>
</head>

<body>
<div class="container">
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-6">
                <img src="/images/logo.png">
            </div>
        </div>
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-6">
                <h2>Create an Account</h2>
            </div>
        </div>
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-6">
                <form method="post" action="<?php $self ?>" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="fName">First Name</label>
                        <input type="text" name="fName" class="form-control" id="fName" placeholder="Joe" required>
                    </div>
                        <div class="form-group col-md-6">
                            <label for="lName">Last Name</label>
                            <input type="text" name="lName" class="form-control" id="lName" placeholder="Sample" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="joe.sample@email.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="25 character maximum" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address">Street Address</label>
                            <input type="address" name="address" class="form-control" id="address" placeholder="100 character maximum" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" id="city" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="state">State</label>
                            <input type="text" name="state" class="form-control" id="state" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="zip-code">ZIP Code</label>
                            <input type="number" name="zip-code" class="form-control" id="zip-code" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="profilePic">Upload a Profile Picture!</label>
                            <input type="file" class="form-control-file" name="profilePic" accept=".jpg,.JPEG,.JPG,.jpeg,.png,.PNG,.gif,.GIF">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Done</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-sm-center">
            <div class="col-sm-6 col-md-5 col-lg-4">
                <p>Already have an account?<br><a href="logIn.php">Sign in!</a></p>
            </div>
        </div>
    </div>
     <!-- jQuery CDN links for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>