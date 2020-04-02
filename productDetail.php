<!-- productDetail.php - product detail page
      
    -->


<!DOCTYPE html>
<html>
<?php
session_start();

require_once('util/config.html');
include('util/db-config.php');
//include('databaseConnection.php');
$error = "";
$errormsg = "";
// if productId was sent by GET
// display information.
if (isset($_GET['productId'])) {
    //clean it up
    if (!is_numeric($_GET['productId'])) {
        //Non numeric value entered. Someone tampered with the bookid
        $error = true;
        $errormsg = " Security, Serious error. Contact webmaster: productId enter: " . $_GET['productId'] . "";
    } else {
        //book_id is numeric number
        //clean it up
        $productId = mysqli_real_escape_string($conn, $_GET['productId']);
        $sql = "CALL getProductInfo('$productId')";
        $result = $conn->query($sql);
        $conn->next_result(); // allow next query to execute
        if ($result) {
            $product = mysqli_fetch_assoc($result);
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
        if($conn->query($sql)) {
            echo '<script>alert("Message Sent")</script>'; 
        }
        
    }
}
?>

<head>
    <title>Product Detail</title>
</head>

<body>
    <br>

    <!-- Page Content -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                        <img class="img-fluid" src="images/1.jpg" alt="">
                    </div>
                    <!-- <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">Product reviews goes here</div>
                    <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">Place for buyer to message seller</div> -->
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Description</a>
                        <!-- <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews</a>
                        <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#nav-message" role="tab" aria-controls="nav-message" aria-selected="false">Message Seller</a> -->
                    </div>
                </nav>


            </div>
            <div class="col-md-4">
                <h3 class="my-3"><?= $product['productName']; ?></h3>
                <p>Brand: Nike</p>
                <p>Availability: In Stock</p>
                <br>
                <h5>Price: $<?= $product['productPrice']; ?></h5>

                <form action="">
                    <label for="">Choice 1</label>
                    <select name="" id="">
                        <option value="">1</option>

                    </select>
                    <br>
                    <label for="">Choice 2</label>
                    <select name="" id="">
                        <option value="">1</option>

                    </select>

                    <br>

                    <button class="btn btn-primary">Add to Cart</button>
                </form>

                <br>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Description</a>
                        <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews</a>
                        <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#nav-message" role="tab" aria-controls="nav-message" aria-selected="false">Message Seller</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab"><?= $product['productDesc']; ?></div>
                    <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
                        <?php
                        $sql = "CALL getProductReview(" . $product['productId'] . ");";
                        $result = $conn->query($sql);
                        if ($result) {
                            $productReview = mysqli_fetch_assoc($result);
                        } // TODO -- implement some way to handle 0 or multiple reviews
                        ?>

                        <p><?= $productReview['userEmail']; ?></p>
                        <span> Rate: <?= $productReview['reviewRating']; ?>/5</span>
                        <p>Comment: <?= $productReview['reviewContent']; ?></p>

                    </div>
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
                        <?php }else { ?>
                            <div>
                                <h5>Please sign in to message the seller</h5>
                                <a href="logIn.php" type="button" class="btn btn-primary">Sign in</a>
                                <!-- <button class="btn btn-primary" href="logIn.php">Sign in</button> -->
                            </div>

                        <?php } ?> 
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <h3 class="my-4">Related Products</h3>

        <div class="row">

            <div class="col-md-3 col-sm-6 mb-4">
                <a href="#">
                    <img class="img-fluid" src="images/1.jpg" alt="">
                </a>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <a href="#">
                    <img class="img-fluid" src="images/1.jpg" alt="">
                </a>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <a href="#">
                    <img class="img-fluid" src="images/1.jpg" alt="">
                </a>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <a href="#">
                    <img class="img-fluid" src="images/1.jpg" alt="">
                </a>
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

</body>

</html>