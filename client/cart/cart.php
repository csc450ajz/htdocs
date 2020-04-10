<!DOCTYPE html>
<html lang="en">
<?php
// check that user is logged in, if not kick to login page
require_once('../../util/check-login.php');
if(!checkLogin()) {
    header("Location: ../../logIn.php");
}
// get db connection
include('../../util/db-config.php');
// get navbar
require_once('../../util/config.php');
// get items in cart
require_once('cart-utility.php');
$cartResult = getCartItems($conn);


?>

<head>
    <title>cart.php</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>Your Cart</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="margin: 0;">Products</h4>
                        </div>
                        <div class="card-body">
                        <?php
                        $total_price = 0;
                        if($cartResult) {
                            while ($cartItems = mysqli_fetch_assoc($cartResult)) {
                                // echo $cartItems['productId'];
                                $sql = "SELECT * FROM Product WHERE productId= " . $cartItems['productId'];
                                $result2 = $conn->query($sql);
                                echo $conn->error;
                                while ($product = mysqli_fetch_assoc($result2)) {
                                    $total_price += ($product['productPrice']);
                        ?>
                        <div class="col" id="card<?= $cartItems['productId'];?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                                $id = $cartItems['productId'];
                                                $sql = "SELECT imagePath FROM ProductImage WHERE productId='$id' LIMIT 1;";
                                                // DEBUG echo $sql;
                                                $conn->next_result();
                                                $imageResult = $conn -> query($sql);
                                                $row = mysqli_fetch_assoc($imageResult);
                                            ?>
                                            <img src="../<?php echo $row['imagePath'];?>" onerror="this.src='../../images/placeholder.jpg';" alt="" class="img-fluid img-thumbnail">
                                        </div>
                                        <div class="col-md-6">
                                            <h5><?= $product['productName'] ?></h5>
                                            <a class="btn-sm btn-success" href="/productDetail.php?productId=<?= $id?>";>View</a>
                                            <hr>
                                            <p>
                                                $<?= number_format($product['productPrice'], 2); ?>
                                                <form method="post" id="deleteCartItem">
                                                    <input type="submit" value="Remove" id="<?=$id?>" style="float: right;" class="deleteChat btn-sm btn-danger">
                                                </form>
                                                <form method="post" action="../order/placeOrder.php">
                                                    <input type="hidden" name="productId" value="<?=$id?>">
                                                    <input type="submit" value="Place Order" style="float: left;" class="btn-sm btn-primary">
                                                </form>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <?php
                                }
                            }
                        }?>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Summary</div>
                        <div class="card-body">
                            <p class="card-text">Total of Items in Cart:<span style="float: right;"><strong><?php echo "$ " . number_format($total_price, 2); ?></span> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    require_once('../../footer.html');

    ?>

</body>
<script>
    $(document).ready(function() {

        $('#deleteCartItem').on('submit', function(event) {
            event.preventDefault();
        }); 
        $('.deleteChat').click(function() {
            var deleteId = $(this).attr("id");
            deleteCartItem(deleteId);
            var id = '#card' + deleteId;
            console.log(id);
            $(id).remove();
            
        });
        function deleteCartItem(deleteId) {
            $.ajax({
                url: "cartAJAX.php",
                method: "post",
                data: {
                    deleteId: deleteId
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }

    });
</script>
</html>