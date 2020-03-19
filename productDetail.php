<!-- productDetail.php - product detail page
      
    -->


<!DOCTYPE html>
<html>
<?php
require_once('util/config.html');
include('util/db-config.php');
//include('databaseConnection.php');

$error = "";
$errormsg = "";
//check if
//A) a bookid has been submitted
//B) the submitted value is numeric
if (isset($_GET['productId'])) {
    //clean it up
    if (!is_numeric($_GET['productId'])) {
        //Non numeric value entered. Someone tampered with the bookid
        $error = true;
        $errormsg = " Security, Serious error. Contact webmaster: productId enter: " . $_GET['productId'] . "";
    } else {
        //book_id is numeric number
        //clean it up
        // $id =preg_replace('/\D/', '', $_GET['productID']) ;
        $productId = mysqli_real_escape_string($conn, $_GET['productId']);
        $sql = "SELECT * FROM product WHERE product.productId ='$productId' ";
        $result = $conn->query($sql);
        if ($result) {
            $num = mysqli_num_rows($result);
            $product = mysqli_fetch_assoc($result);
        } //results
        else {
            //there's a query error
            // $error = true;
            // $errormsg .= mysqli_error($error);
        } //result test
    } //numeric
} //if isset
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
                        $sql = "SELECT * FROM productReview WHERE productReview.productId = " . $product['productId'];
                        $result = $conn->query($sql);
                        if ($result) {
                            $productReview = mysqli_fetch_assoc($result);
                        } //results
                        ?>

                        <p><?= $productReview['userEmail']; ?></p>
                        <span> Rate: <?= $productReview['reviewRating']; ?>/5</span>
                        <p>Comment: <?= $productReview['reviewContent']; ?></p>

                    </div>
                    <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">Place for buyer to message seller</div>
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