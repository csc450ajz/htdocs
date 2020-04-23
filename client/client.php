<!DOCTYPE html>
<html lang="en">
<?php
require_once('../util/config.php');
// check that user is logged in, if not kick to login page
if (!checkLogin()) {
    header("Location: logIn.php");
}

if (isset($_POST['adminMessage'])) {
    $issueId = $_POST['issueId'];
    $userEmail = $_POST['userEmail'];
    $messageText = $_POST['messageText'];
    $sql = "INSERT INTO adminmessages (clientEmail, issueId, messageText, messageTime) VALUES('$userEmail', '$issueId', '$messageText', CURRENT_TIMESTAMP)";
    $result = $conn->query($sql);
}

if (isset($_POST['deleteIssue'])) {
    $issueId = $_POST['issueId'];
    $sql = "DELETE FROM issue WHERE issueId='$issueId'";
    if ($conn->query($sql)) {
        $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
        $tabTag = "{$tabTag}#messages";
        header("Location: {$currentUrl}{$tabTag}");
    }
}

if (array_key_exists('hdnMessage', $_POST)) {
    if (isset($_POST['productMessage'])) {
        $chatId = $_POST['chatId'];
        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['messageText'];
        // echo ($messageText);
        $sql = "INSERT INTO chatmessages (userEmail, chatId, messageText, messageSentTime) VALUES('$userEmail', '$chatId', '$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        $sql = "UPDATE productchat SET recentSender='$userEmail' WHERE chatId = '$chatId'";
        $conn->query($sql);
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
        }
    } elseif (isset($_POST['deleteChat'])) {
        $chatId = $_POST['deleteChat'];
        $sql = "DELETE FROM productChat WHERE chatId = '$chatId'";
        if ($conn->query($sql)) {
            $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
            $tabTag = "#messages";

            header("Location: {$currentUrl}{$tabTag}");
        }
    }
}


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

function totalProductSold($conn, $userEmail)
{
    $sql = "SELECT * FROM orders WHERE sellerEmail='$userEmail'";
    $result = $conn->query($sql);
    $total = mysqli_num_rows($result);
    $conn->next_result();
    echo $conn->error;
    return $total;
}

function totalOrdersMade($conn, $userEmail)
{
    $sql = "SELECT * FROM orders WHERE buyerEmail='$userEmail'";
    $result = $conn->query($sql);
    $total = mysqli_num_rows($result);
    $conn->next_result();
    echo $conn->error;
    return $total;
}
?>


<head>
    <title>Seller</title>
</head>

<?php
require_once('../util' . $navbar);
?>
<style>
    .nav-mytabs {
        margin-top: 2rem;
    }

    .nav-mytabs li:not(:last-child) {
        margin-right: 7px;
    }

    .nav-mytabs a {
        position: relative;
        top: 4px;
        padding: 10px 25px;
        border-radius: 2px 2px 0 0;
        background: lightslategray;
        color: white;
        opacity: 0.7;
        transition: all 0.1s ease-in-out;
    }

    .nav-mytabs a.active,
    .nav-mytabs a:hover {
        opacity: 1;
        top: 0;
    }
</style>
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
<style>
    #profile-pic {
        background: gray;
    }
</style>
<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-4">Welcome, <?= $userFName ?>!</h3>
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
                                <?PHP
                                $userEmail = $_SESSION['userEmail'];
                                $sql = "SELECT * FROM User WHERE User.userEmail = '$userEmail' LIMIT 1;";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="card-header">Quick Profile Info</div>
                                <img id="profile-pic" class="card-img-top" src="../<?PHP echo $row['userPhotoPath'] ?>" onerror="this.src='../images/profile.png';" alt="Profile picture">
                                <div class="card-body text-dark">
                                    <h5 class="card-title"><?PHP echo $row['userFName'] . " " . $row['userLName']; ?></h5>
                                    <dl>
                                        <dt>Email:</dt>
                                        <dd><?PHP echo $row['userEmail']; ?></dd>
                                        <dt>Cash Balance:</dt>
                                        <dd>$<?PHP echo $row['userBalance']; ?></dd>
                                    </dl>
                                    <form action="editProfile.php">
                                        <button type="submit">Edit Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Products Sold</strong></div>
                                        <div class="card-body" align="center">
                                            <h1><?= totalProductSold($conn, $userEmail) ?></h1>
                                            <h5>Revenue: $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Orders Made</strong></div>
                                        <div class="card-body" align="center">
                                            <h1><?= totalOrdersMade($conn, $userEmail) ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <br>
                    <div>
                        <h3><i class="fas fa-edit" data-toggle="modal" data-target="#messageModal" style="cursor: pointer; float: right;"></i></h3>
                    </div>
                    <br>
                    <h5>Message With Sellers and Buyers</h5>
                    <?php
                    require_once('../client/messages/messages.php');

                    ?>

                    <hr />

                    <h5>Message With Admins</h5>
                    <?php
                    require_once('../client/messages/adminMessages.php');

                    ?>
                </div>
                <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                    <br>
                    <div class="accordion" id="productsTab">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#selling">
                                        Selling
                                    </button>
                                </h5>
                            </div>

                            <div id="selling" class="collapse" data-parent="#productsTab">
                                <div class="card-body">

                                    <?php
                                    if ($sellingResult) {
                                        if (mysqli_num_rows($sellingResult) > 0) {

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
                                                        $sql = "SELECT imagePath FROM ProductImage WHERE productId=" . $sellingItems['productId'] . " LIMIT 1;";
                                                        $imageResult = $conn->query($sql);
                                                        $row = mysqli_fetch_assoc($imageResult);
                                                        ?>
                                                        <img src="../<?PHP echo $row['imagePath']; ?>" style="max-height: 125px; width: auto;" class="img-fluid img-thumbnail">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3><?= $product['productName'] ?></h3>
                                                        <h4>$<?= $product['productPrice'] ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <?php
                                                }
                                            }
                                        } else {
                                            echo '<h4>You did not post products for sale yet!</h4>';
                                        }
                                    }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#postProduct" aria-expanded="false" aria-controls="collapseTwo">
                                            Post Product
                                        </button>
                                    </h5>
                                </div>
                                <div id="postProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#productsTab">
                                    <div class="card-body">
                                        <?php
                                        require_once('postProduct.php');

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Sold
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#productsTab">
                                    <div class="card-body">
                                        <?php
                                        if ($soldResult) {
                                            if (mysqli_num_rows($soldResult) > 0) {

                                                while ($orderItems = mysqli_fetch_assoc($soldResult)) {
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
                                                                            <?php 
                                                                                $sql = "SELECT imagePath FROM ProductImage WHERE productId = " . $orderItems['productId'];
                                                                                $conn->next_result();
                                                                                $result3 = $conn->query($sql);
                                                                                $imagePath = mysqli_fetch_assoc($result3);
                                                                            ?>
                                                                            <img src="<?=$imagePath['imagePath'];?>" onerror="this.src='/images/placeholder.jpg';" class="img-fluid img-thumbnail">
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
                                            } else {
                                                echo '<h4>You do not have sold products</h4>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#purchased" aria-expanded="false" aria-controls="collapseThree">
                                            Purchased
                                        </button>
                                    </h5>
                                </div>
                                <div id="purchased" class="collapse" aria-labelledby="headingThree" data-parent="#productsTab">
                                    <div class="card-body">
                                        <?php
                                        if ($purchasedResult) {
                                            if (mysqli_num_rows($purchasedResult) > 0) {

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
                                                            <?php 
                                                                $sql = "SELECT imagePath FROM ProductImage WHERE productId = " . $orderItems['productId'];
                                                                $conn->next_result();
                                                                $result4 = $conn->query($sql);
                                                                $imagePath = mysqli_fetch_assoc($result3);
                                                            ?>
                                                            <img src="<?=$imagePath['imagePath'];?>" onerror="this.src='/images/placeholder.jpg';" class="img-fluid img-thumbnail">
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
                                            } else {
                                                echo '<h4>You did not buy any products</h4>';
                                            }
                                        }
                                        ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once('../footer.html');
            ?>
        </div>
</body>
</html>