<?php
// if user is already logged in, redirect to profile page
include('../util/config.php');
if (!checkLogin()) {
    header('Location: /logIn.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = $_SESSION['userEmail'];
    // gather form values
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $password = $_POST['password'];

    //Store Image
    require_once('../util/image-util.php');
    $photoPath = storeProfileImage($_FILES['profilePic']);

    // Update Profile   
    $sql = "UPDATE User SET userFName = '$fName', userLName = '$lName', userPassword = '$password', userPhotoPath = '$photoPath' WHERE userEmail = '$userEmail'";
    $result = $conn->query($sql);
}

//Get user detail for editing
$sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html>
<?php
require_once(('../util' . $navbar));


?>

<head>
    <title>Sportrader - Edit Profile</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-8">
                <h1>Edit Profile</h1>
            </div>
        </div>
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-8">
                <form method="post" action="<?php $self ?>" enctype="multipart/form-data" id="profile-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fName">First Name</label>
                            <input type="text" name="fName" class="form-control" id="fName" value="<?= $row['userFName'] ?>" maxlength="100" >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lName">Last Name</label>
                            <input type="text" name="lName" class="form-control" id="lName" value="<?= $row['userLName'] ?>" maxlength="100" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">New Password</label>
                            <input type="text" name="password" class="form-control" id="password" placeholder="New Password" maxlength="100" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="profilePic">Upload a Profile Picture!</label>
                            <input type="file" class="form-control-file" name="profilePic" accept=".jpg,.JPEG,.JPG,.jpeg,.png,.PNG,.gif,.GIF">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>