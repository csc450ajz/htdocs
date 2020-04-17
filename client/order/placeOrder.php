<!DOCTYPE html>
<html lang="en">
<?php
// check that user is logged in, if not kick to login page
require_once('../../util/config.php');
// get items in cart
require_once('../cart/cart-utility.php');
$productId = $_POST['productId'];
?>

<head>
    <title>cart.php</title>
</head>
<style>
    h4 {
        margin: 0;
    }
</style>
<?php
require_once('../../util'.$navbar);
?>
<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>Your Order</h2>
                </div>
            </div>
            <hr/>
            <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Product</h4>
                    </div>
                    <div class="card-body">
                            <?php
                            $sql = "SELECT * FROM Product WHERE productId = '$productId'";
                            $result2 = $conn->query($sql);
                            echo $conn->error;
                            $product = mysqli_fetch_assoc($result2);
                            $price = $product['productPrice'];
                            ?>

                            <div class="col" id="card<?= $cartItems['productId'];?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                    $sql = "SELECT imagePath FROM ProductImage WHERE productId='$productId' LIMIT 1;";
                                                    // DEBUG echo $sql;
                                                    $conn->next_result();
                                                    $imageResult = $conn -> query($sql);
                                                    $row = mysqli_fetch_assoc($imageResult);
                                                ?>
                                                <img src="../<?php echo $row['imagePath'];?>" onerror="this.src='../../images/placeholder.jpg';" alt="" class="img-fluid img-thumbnail">
                                            </div>
                                            <div class="col-md-6">
                                                <h5><?= $product['productName'] ?></h5>
                                                <a class="btn-sm btn-success" href="/productDetail.php?productId=<?= $productId?>";>View</a>
                                                <hr>
                                                <p>
                                                    $<?= number_format($product['productPrice'], 2); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <form method="post" action="completeOrder.php">
                        <div class="card">
                            <div class="card-header">
                                <h4>Shipping Address</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                <br/>
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
                            </div>
                        </div>
                        <?php
                            $userEmail = $_SESSION['userEmail'];
                            $sql = "SELECT userBalance FROM User WHERE userEmail='$userEmail';";
                            $conn->next_result();
                            $balanceResult = $conn->query($sql);
                            $row = mysqli_fetch_assoc($balanceResult);
                            $balance = floatval($row['userBalance']);
                        ?>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <h4>Summary</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Your Balance<span style="float: right;"><strong>$<?php echo number_format($balance, 2); ?></strong></span></p>
                                <hr>
                                <p class="card-text"><strong>TOTAL<span style="float: right;"><?php echo "$" . number_format($price, 2); ?></strong></span></p>
                                <hr>
                                <p class="card-text">Balance after purchase:<span style="float: right;"><strong>$<?php $remaining = $balance-$price; echo number_format($remaining, 2); ?></strong></span></p>
                                <hr>
                                <a class="btn btn-danger" href="../cart/cart.php" style="color: white;">Cancel</a>
                                <input type="hidden" name="place_order" value="<?=$productId?>">
                                <button type="submit" <?PHP if($remaining < 0) {echo "disabled ";}?>style="float: right;" class="btn btn-primary">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php
    require_once('../../footer.html');

    ?>

</body>

</html>