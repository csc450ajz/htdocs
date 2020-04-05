<!DOCTYPE html>
<html lang="en">
<?php
// check that user is logged in, if not kick to login page
require_once('../util/check-login.php');
if (!checkLogin()) {
    header("Location: logIn.php");
}
//Database Connection
include('../util/db-config.php');


if (array_key_exists('hdnMessage', $_POST)) {
    if (isset($_POST['productMessage'])) {
        $chatId = $_POST['productMessage'];
        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['messageText'];
        // echo ($messageText);
        $sql = "INSERT INTO chatmessages (userEmail, chatId, messageText, messageSentTime) VALUES('$userEmail', '$chatId', '$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);
        // echo $result;
    } elseif (isset($_POST['issueMessage'])) {
        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['issueText'];
        $issueType = $_POST['issueType'];

        $sql = "INSERT INTO issue (clientEmail, issueType, issueText, issueDateSubmitted) VALUES('$userEmail', '$issueType' ,'$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        $issueId = mysqli_insert_id($conn);
        $sql = "INSERT INTO adminmessages (clientEmail, issueId, messageText, messageTime) VALUES ('$userEmail', '$issueId', '$messageText', CURRENT_TIMESTAMP)";
        if ($conn->query($sql)) {
            echo '<script>alert("Message Sent")</script>';
        }
    } elseif (isset($_POST['deleteChat'])) {
        $chatId = $_POST['deleteChat'];
        $sql = "DELETE FROM productChat WHERE chatId = '$chatId'";
        $conn->query($sql);
    }
}


//Get Navigation Bar
require_once('../util/config.html');

//Get Sold Items
function getSoldItems($conn)
{
    //Check User LogIn
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        //Execute Stored Procedure
        $sql = "CALL getSoldItems('$userEmail');";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
} //End of Function
$soldResult = getSoldItems($conn);

//Get Selling Items
function getSellingItems($conn)
{
    //Check User LogIn
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        //Execute Stored Procedure
        $sql = "CALL getSellingItems('$userEmail');";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
} //End of Function
$sellingResult = getSellingItems($conn);

//Get Purchased Items
function getPurchasedtems($conn)
{
    //Check User LogIn
    if (isset($_SESSION['userEmail'])) {
        $userEmail = $_SESSION['userEmail'];

        //Execute Stored Procedure
        $sql = "CALL getPurchasedItems('$userEmail');";
        $result = $conn->query($sql);
        $conn->next_result();
        echo $conn->error;
        return $result;
    }
} //End of Function
$purchasedResult = getPurchasedtems($conn);

?>


<head>
    <title>Seller</title>
</head>

<style>
    #profile-pic {
        background: gray;
    }
</style>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-4">Welcome</h3>

            <nav>
                <!-- Define Tabs -->
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                    <a class="nav-item nav-link" id="nav-messages-tab" data-toggle="tab" href="#nav-messages" role="tab" aria-controls="nav-messages" aria-selected="false">Messages</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-spinner" role="tab" aria-controls="nav-spinner" aria-selected="false">Spinner</a>
                    <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-product" aria-selected="false">Products</a>
                </div>
            </nav>

            <!-- Start of Tabs -->
            <div class="tab-content" id="nav-tabContent">

                <!-- Home Tab -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-dark mb-3 " style="margin-bottom: unset!important;">
                                <?PHP 
                                    $userEmail = $_SESSION['userEmail'];
                                    $sql = "SELECT * FROM User WHERE User.userEmail = '$userEmail' LIMIT 1;";
                                    $result = $conn->query($sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="card-header">Quick Profile Info</div>
                                <img id="profile-pic" class="card-img-top" src="../<?PHP echo $row['userPhotoPath']?>" onerror="this.src='../images/placeholder.jpg';" alt="Profile picture">
                                <div class="card-body text-dark">
                                    <h5 class="card-title"><?PHP echo $row['userFName']." ".$row['userLName'];?></h5>
                                    <dl>
                                        <dt>Email:</dt>
                                        <dd><?PHP echo $row['userEmail'];?></dd>
                                        <dt>Cash Balance:</dt>
                                        <dd>$<?PHP echo $row['userBalance'];?></dd>
                                    </dl>
                                    <button>Edit Profile</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Users</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>100</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Categories</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>10</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Unread Messages</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>15</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Coupons</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>8</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Tab -->
                <div class="tab-pane fade" id="nav-messages" role="tabpanel" aria-labelledby="nav-messages-tab">
                    <div class="row">
                        <div class="col-2">
                            <a href="#" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-edit"></i> New Message</a>
                        </div>
                        <div class="col-10">
                            <h3>Messages</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Inbox</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Sent</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Draft</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Trash</a>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <?php
                                    require_once('../util/messages/messages.php');

                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spinner Tab -->
            <div class="tab-pane fade" id="nav-spinner" role="tabpanel" aria-labelledby="nav-spinner-tab">...
            </div>

            <!-- Products Tab -->
            <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                <div class="row">
                    <div class="col-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-sold-tab" data-toggle="pill" href="#v-pills-sold" role="tab" aria-controls="v-pills-sold" aria-selected="true">Sold</a>
                            <a class="nav-link" id="v-pills-selling-tab" data-toggle="pill" href="#v-pills-selling" role="tab" aria-controls="v-pills-selling" aria-selected="false">Selling</a>
                            <a class="nav-link" id="v-pills-purchased-tab" data-toggle="pill" href="#v-pills-purchased" role="tab" aria-controls="v-pills-purchased" aria-selected="false">Purchased</a>
                            <a class="nav-link" id="v-pills-add-tab" data-toggle="pill" href="#v-pills-add" role="tab" aria-controls="v-pills-add" aria-selected="false">Add Item</a>
                        </div>
                    </div>
                    <div class="col-10">
                        <!-- Start Product of Tabs -->
                        <div class="tab-content" id="v-pills-tabContent">
                            <!-- Sold Tab -->
                            <div class="tab-pane fade show active" id="v-pills-sold" role="tabpanel" aria-labelledby="v-pills-sold-tab">
                                <?php
                                if ($soldResult) {
                                    while ($orderItems = mysqli_fetch_assoc($soldResult)) {
                                        //echo $orderItems['productId'];
                                        $sql = "SELECT * FROM Product WHERE productId= " . $orderItems['productId'];
                                        $result2 = $conn->query($sql);
                                        echo $conn->error;
                                        while ($product = mysqli_fetch_assoc($result2)) {
                                ?>
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="images/balls.jpg" alt="" class="img-fluid img-thumbnail">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h3><?= $product['productName'] ?></h3>
                                                                <h4>$<?= $product['productPrice'] ?></h4>
                                                                <!--<p><i>Purchased by: <?= $product['userEmail'] ?></i></p> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <!-- Selling Tab -->
                            <div class="tab-pane fade" id="v-pills-selling" role="tabpanel" aria-labelledby="v-pills-selling-tab">
                                <?php
                                if ($sellingResult) {
                                    while ($sellingItems = mysqli_fetch_assoc($sellingResult)) {
                                        //echo $sellingItems['productId'];
                                        $sql = "SELECT * FROM Product WHERE productId= " . $sellingItems['productId'];
                                        $result2 = $conn->query($sql);
                                        echo $conn->error;
                                        while ($product = mysqli_fetch_assoc($result2)) {
                                ?>
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <?PHP
                                                                    $conn->next_result();
                                                                    $sql = "SELECT imagePath FROM ProductImage WHERE productId=".$sellingItems['productId']." LIMIT 1;";
                                                                    $imageResult = $conn->query($sql);
                                                                    $row = mysqli_fetch_assoc($imageResult);
                                                                ?>
                                                                <img src="../<?PHP echo $row['imagePath'];?>" alt="" width="125px" class="img-fluid img-thumbnail">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h3><?= $product['productName'] ?></h3>
                                                                <h4>$<?= $product['productPrice'] ?></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <!-- Purchased Tab -->
                            <div class="tab-pane fade" id="v-pills-purchased" role="tabpanel" aria-labelledby="v-pills-purchased-tab">
                                <?php
                                if ($purchasedResult) {
                                    while ($orderItems = mysqli_fetch_assoc($purchasedResult)) {
                                        //echo $orderItems['productId'];
                                        $sql = "SELECT * FROM Product WHERE productId= " . $orderItems['productId'];
                                        $result2 = $conn->query($sql);
                                        echo $conn->error;
                                        while ($product = mysqli_fetch_assoc($result2)) {
                                ?>
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="images/balls.jpg" alt="" class="img-fluid img-thumbnail">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h3><?= $product['productName'] ?></h3>
                                                                <h4>$<?= $product['productPrice'] ?></h4>
                                                                <p><i>Sold by: <?= $product['userEmail'] ?></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <!-- Add Item Tab -->
                            <div class="tab-pane fade" id="v-pills-add" role="tabpanel" aria-labelledby="v-pills-add-tab">
                                <!-- Link to postProduct.php -->
                                <?php
                                require_once('postProduct.php');

                                ?>
                            </div>

                        </div>
                    </div>
                </div> <!-- End of Product Tabs -->
            </div>
        </div>
    </div> <!-- End of Tabs -->

    </div>
    </div>
</body>

</html>