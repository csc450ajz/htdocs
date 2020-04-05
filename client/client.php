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

if (isset($_POST['adminMessage'])) {
    $issueId = $_POST['issueId'];
    $userEmail = $_POST['userEmail'];
    $messageText = $_POST['messageText'];
    // echo ($messageText);
    $sql = "INSERT INTO adminmessages (clientEmail, issueId, messageText, messageTime) VALUES('$userEmail', '$issueId', '$messageText', CURRENT_TIMESTAMP)";
    $result = $conn->query($sql);
}

if (array_key_exists('hdnMessage', $_POST)) {
    if (isset($_POST['productMessage'])) {
        $chatId = $_POST['chatId'];
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
            $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
            $tabTag = "#messages";

            header("Location: {$currentUrl}{$tabTag}");
            // echo '<script>$("a[href="#nav-messages"]").tab("show")</script>';
        }
    } elseif (isset($_POST['deleteChat'])) {
        $chatId = $_POST['deleteChat'];
        $sql = "DELETE FROM productChat WHERE chatId = '$chatId'";
        if ($conn->query($sql)) {
            $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
            $tabTag = "#messages";

            header("Location: {$currentUrl}{$tabTag}");
            // echo '<script>$("a[href="#nav-messages"]").tab("show")</script>';
        }
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
<script>
    $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");
        if (location.hash) {
            const hash = url.split("#");
            $('#myTab a[href="#' + hash[1] + '"]').tab("show");
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        }

        $('a[data-toggle="tab"]').on("click", function() {
            let newUrl;
            const hash = $(this).attr("href");
            if (hash == "#nav-home") {
                newUrl = url.split("#")[0];
            } else {
                newUrl = url.split("#")[0] + hash;
            }
            newUrl += "/";
            history.replaceState(null, null, newUrl);
        });
    });
</script>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-4">Welcome</h3>
            <ul class="nav nav-mytabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="categories" aria-selected="false">Products</a>
                </li>
            </ul>
            <div class="tab-content mytab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-dark mb-3 " style="margin-bottom: unset!important;">
                                <div class="card-header">Quick Profile Info</div>
                                <img class="card-img-top" src="../images/profile.jpg" alt="Card image cap">
                                <div class="card-body text-dark">
                                    <h5 class="card-title">My Name</h5>
                                    <p class="card-text">User Details Below: email, username, etc.</p>
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
                            </div>

                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="container">
                        <h3>Messages <i class="fas fa-edit" data-toggle="modal" data-target="#messageModal" style="cursor: pointer; float: right;"></i></h3>
                    </div>
                    <h5>Message With Sellers and Buyers</h5>
                    <?php
                    require_once('../client/messages/messages.php');

                    ?>

                    <hr />

                    <!-- <h5>Message With Admins</h5>
                    <?php
                    // require_once('../client/messages/adminMessages.php');

                    ?> -->
                </div>
                <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-sold-tab" data-toggle="pill" href="#v-pills-sold" role="tab" aria-controls="v-pills-sold" aria-selected="true">Sold</a>
                                <a class="nav-link" id="v-pills-selling-tab" data-toggle="pill" href="#v-pills-selling" role="tab" aria-controls="v-pills-selling" aria-selected="false">Selling</a>
                                <a class="nav-link" id="v-pills-purchased-tab" data-toggle="pill" href="#v-pills-purchased" role="tab" aria-controls="v-pills-purchased" aria-selected="false">Purchased</a>
                                <a class="nav-link" id="v-pills-add-tab" data-toggle="pill" href="#v-pills-add" role="tab" aria-controls="v-pills-add" aria-selected="false">Post Product</a>
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
                                                                    <img src="images/balls.jpg" alt="" class="img-fluid img-thumbnail">
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
                    </div>
                </div>
            </div>
        </div> <!-- End of Tabs -->

    </div>
    <?php
    require_once('./../footer.html');

    ?>
</body>

</html>