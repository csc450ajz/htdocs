<!DOCTYPE html>
<html lang="en">
<?php
// check that user is logged in, if not kick to login page
require_once('util/check-login.php');
if(!checkLogin()) {
    header("Location: /login.php");
}
// get db connection
//include('databaseConnection.php');
include('util/db-config.php');
// get navbar
require_once('util/config.html');
// get items in cart
require_once('util/cart-utility.php');
$cartResult = getCartItems($conn);
?>

<head>
    <title>cart.php</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h2>Shopping Cart</h2>
            <hr />

            <div class="row">
                <div class="col-md-8">
                    <?php
                    $total_price = 0;
                    while ($cartItems = mysqli_fetch_assoc($cartResult)) {
                        // echo $cartItems['productId'];
                        $sql = "SELECT * FROM Product WHERE productId= " . $cartItems['productId'];
                        $result2 = $conn->query($sql);
                        echo $conn->error;
                        while ($product = mysqli_fetch_assoc($result2)) {
                            $total_price += ($product['productPrice']);
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
                    ?>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Summary</div>
                        <div class="card-body">
                            <p class="card-text">TOTAL <span style="float: right;"><strong><?php echo "$ " . number_format($total_price, 2); ?></span> </p>
                            <button class="btn btn-success">Place Order</button>
                            <button class="btn btn-danger" style="float: right;">Cancel</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php
    require_once('footer.html');

    ?>

</body>

</html>