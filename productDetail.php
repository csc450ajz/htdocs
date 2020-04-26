<!DOCTYPE html>
<html lang="en">
<?php
// get config file
require_once('util/config.php');
?>
<head>
    <title>cart.php</title>
    <link rel='stylesheet' href='style/products.css'>
</head>
<?php

// if productId is passed in POST, add to cart
if (isset($_POST['productId'])) {
    require_once("client/cart/cart-utility.php");
    addCartItem($_POST['productId'], $conn);
}

require_once('util' . $navbar);
$error = "";
$errormsg = "";
// if productId was sent by GET
// display information.
if (isset($_GET['productId'])) {
    //clean it up
    if (!is_numeric($_GET['productId'])) {
        //Non numeric value entered. Someone tampered with the productId
        $error = true;
        $errormsg = " Security, Serious error. Contact webmaster: productId enter: " . $_GET['productId'] . "";
    } else {
        //clean it up
        $productId = mysqli_real_escape_string($conn, $_GET['productId']);
        $sql = "CALL getProductInfo('$productId')";
        $result = $conn->query($sql);
        $conn->next_result(); // allow next query to execute
        if ($result) {
            $product = mysqli_fetch_assoc($result);
            $productViews = $product['productViews'] + 1;
            updateProductViews($conn, $product['productId'], $productViews);
        } else {
            //there's a query error
            // TODO - Implement an error message to tell user that the product is not available.
        }
    }
}

if (array_key_exists('hdnMessage', $_POST)) {
    if (isset($_POST['productMessage'])) {

        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['messageText'];
        $sellerEmail = $_POST['sellerEmail'];
        $productId = $_POST['hdnMessage'];
        $conn->next_result();

        $sql = "INSERT INTO productchat (buyerEmail, sellerEmail, productId, recentSender) VALUES('$userEmail', '$sellerEmail', '$productId', '$userEmail')";
        $result = $conn->query($sql);

        $chatId = mysqli_insert_id($conn);
        $messageTime = $product['chatStartDat'];
        $sql = "INSERT INTO chatmessages (userEmail, chatId, messageText, messageSentTime) VALUES ('$userEmail', '$chatId', '$messageText', CURRENT_TIMESTAMP)";
        if ($conn->query($sql)) {
            echo '<script>alert("Message Sent")</script>';
        }
    }
}



function updateProductViews($conn, $productId, $productViews)
{
    $sql = "UPDATE product SET productViews='$productViews' WHERE productId='$productId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function getProductImages($conn, $productId)
{
    $sql = "SELECT * FROM productimage WHERE productId='$productId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
$productImagesResults = getProductImages($conn, $product['productId'])
?>

<head>
    <title>Product Detail</title>
</head>
<style>

    /* .productDetail {
        height: 120px;
    } */
</style>
<script>
    $(document).ready(function() {
        // var id = $("#myTab a:first").attr("id");
        // $(".tab-pane").attr("id").val(id);
        $("#myTab a:first").tab('show'); // show first image on page load

        $('a[data-toggle="tab"]').on("click", function() {

        });
    });
</script>

<body>
    <br>

    <!-- Page Content -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8 productDetail">
                <div class="row">
                    <div class="tab-content" id="myTabContent" style="margin:auto">
                        <?php
                        if (mysqli_num_rows($productImagesResults) > 0) {

                            while ($productImages = mysqli_fetch_assoc($productImagesResults)) {

                        ?>
                                <div class="tab-pane fade" id="<?= $productImages['imageID']; ?>">
                                    <img class="" src="<?= $productImages['imagePath']; ?>" alt="" style="width: 90%; height: 400px;" onerror="this.src='images/placeholder.jpg';">
                                </div>
                            <?php }
                        } else {
                            ?>
                            <div class="tab-pane fade" id="placeholder">
                                <img class="" src="images/placeholder.jpg" alt="" style="width: 90%; height: 400px;">
                            </div>
                        <?php } ?>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 80%; align-items: center;">
                        <?php
                        $productImagesResults = getProductImages($conn, $product['productId']);
                        if (mysqli_num_rows($productImagesResults) > 0) {

                            while ($images = mysqli_fetch_assoc($productImagesResults)) {
                        ?>
                                <li class="nav-item col-4" style="padding: 0px">
                                    <a class="nav-link " id="<?= $images['imageID']; ?>" data-toggle="tab" href="#<?= $images['imageID']; ?>">
                                        <img class="img-fluid" src="<?= $images['imagePath']; ?>" alt="" style="width: auto;" onerror="this.src='images/placeholder.jpg';">
                                    </a>
                                </li>
                            <?php }
                        } else { ?>
                            <li class="nav-item col-4" style="padding: 0px">
                                <a class="nav-link " id="placeholder-img" data-toggle="tab" href="#placeholder">
                                    <img class="img-fluid" src="images/placeholder.jpg" alt="" style="width: auto;">
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST" name="frmCart" id="frmCart">

                    <h3 class="my-3"><?= $product['productName']; ?></h3>
                    <p>Brand: <?= $product['productBrand']; ?></p>
                    <p>Availability: In Stock</p>
                    <br>
                    <p>Size: <?= $product['productSize']; ?></p>

                    <h5>Price: $<?= $product['productPrice']; ?></h5>
                    <input type="hidden" name="productId" value="<?= $product['productId'] ?>">

                    <button class="btn btn-primary">Add to Cart</button>
                </form>
                <br>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Description</a>
                        <!-- <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews</a> -->
                        <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#nav-message" role="tab" aria-controls="nav-message" aria-selected="false">Message Seller</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab"><?= $product['productDesc']; ?></div>

                    <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">

                        <?php if (isset($_SESSION['userEmail'])) { ?>
                            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST" name="frmMessage" id="frmMessage">

                                <div class="container">

                                    <div class="row">
                                        <textarea name="messageText" class="form-control" rows="3" placeholder="Enter your message here"></textarea>
                                        <input type='hidden' name='hdnMessage' value='<?= $product['productId']; ?>' />
                                        <input type='hidden' name='sellerEmail' value='<?= $product['userEmail']; ?>' />
                                        <button type="submit" name="productMessage" class="btn btn-success">Send</button>
                                    </div>
                                </div>

                            </form>
                        <?php } else { ?>
                            <div>
                                <h5>Please sign in to message the seller</h5>
                                <a href="logIn.php" type="button" class="btn btn-primary">Sign in</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h3 class="my-4">Related Products</h3>
        <style>
            .related {
                min-height: 350px;
            }
        </style>
        <?php
        $conn->next_result();
        $sql = "SELECT * FROM product WHERE genderId=" . $product['genderId'];
        $result = $conn->query($sql);
        ?>
        <div class="row flex-row flex-nowrap overflow-auto">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    $id = $product['productId'];
                    $sql = "SELECT imagePath FROM ProductImage WHERE productId='$id' LIMIT 1;";
                    // DEBUG echo $sql;
                    $conn->next_result();
                    $imageResult = $conn->query($sql);
                    $images = mysqli_fetch_assoc($imageResult);
            ?>
            <div class="col-xs-8 col-md-6 col-lg-3">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="card related">
                        <img src="<?= $images['imagePath'] ?>" alt="Product Image" onerror="this.src='images/placeholder.jpg';" style="width: auto; height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title"><b><a href="productDetail.php?productId=<?php echo $product['productId']; ?>"><?= $product['productName']; ?></a></b></h5>
                            <p class="card-text">$<?= $product['productPrice']; ?></p>
                            <!-- Send product id as encoded value -->
                            <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />
                        </div>
                    </div>
                </form>
            </div>
            <?php }
            } else {
                echo '<h5></i>No Related Products</i></h5>';
            } ?>
        </div>
        <hr>
    </div>
    <?php require_once('footer.html'); ?>
</body>

</html>