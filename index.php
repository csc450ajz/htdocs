<!DOCTYPE html>
<html lang="en">
<?php
// get navbar
require_once('util/config.php');

// if productId is passed in POST, add to cart
if (isset($_POST['productId'])) {
    require_once("client/cart/cart-utility.php");
    addCartItem($_POST['productId'], $conn);
}

// call getFeaturedProducts() stored procedure
$sql = "CALL getFeaturedProducts();";
$result = $conn->query($sql);
?>

<head>
    <title>Sportrader</title>
</head>
<style>
    h1 {
        text-align: center;
    }
    .row {
        margin: 15px 0px;
    }

    .btn-dark {
        width: 100%;
    }

    .col {
        margin-top: 10px;
    }

    .featured {
        min-height: 400px;
    }
</style>
<?php
require_once('util' . $navbar);
?>
<link rel='stylesheet' href='style/products.css'>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Welcome to Sportrader!</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>What is Sportrader?</h2>
                <p>Think of Sportrader as a cross between eBay and Craigslist, but for sports. We believe Sportrader provides
                the perfect platform for fans of all sports to buy and sell their favorite gear and memorabilia.</p>
            </div>
            <div class="col-md-6">
                <h2>How do I use Sportrader?</h2>
                <p>To get started, create an account and browse the products for sale! If you have something to sell, head into 
                your profile and post it! Also use the Reward button at any time to try your luck at winning more site currency!</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="images/1.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="images/2.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="images/3.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-center">Most Viewed Products</h2>

        <div class="row">

            <?php while ($product = mysqli_fetch_assoc($result)) :
                $id = $product['productId'];
                $sql = "SELECT imagePath FROM ProductImage WHERE productId='$id' LIMIT 1;";
                // DEBUG echo $sql;
                $conn->next_result();
                $imageResult = $conn->query($sql);
                $images = mysqli_fetch_assoc($imageResult);
            ?>

                <div class="col-xs-8 col-md-6 col-lg-3">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                        <div class="card featured">
                            <img src="<?= $images['imagePath'] ?>" alt="Product Image" onerror="this.src='images/placeholder.jpg';" style="width: auto; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><b><a href="productDetail.php?productId=<?php echo $product['productId']; ?>"><?= $product['productName']; ?></a></b></h5>
                                <!-- TODO: Add product star reviews -->
                                <p class="card-text">$<?= $product['productPrice']; ?></p>
                                <!-- Send product id as encoded value -->
                                <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />

                                <button name="btnCart" value="new" class="btn btn-primary">Add to Cart</button>

                            </div>
                        </div>
                    </form>

                </div>

            <?php endwhile; ?>

        </div>


        <hr>


        <hr>
        <?php
        $conn->next_result();
        $sql = "SELECT * FROM product WHERE product.genderId=1";
        $result = $conn->query($sql);



        ?>
        <h2>Featured Men Products</h2>
        <div class="row flex-row flex-nowrap overflow-auto">

            <?php
            $sql = "SELECT * FROM Product WHERE genderId= 1 AND productStatus='active'";
            $result = $conn->query($sql);

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
                        <div class="card" style="min-height: 350px">
                            <img src="<?= $images['imagePath'] ?>" alt="Product Image" onerror="this.src='images/placeholder.jpg';" style="width: auto; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><b><a href="productDetail.php?productId=<?php echo $product['productId']; ?>"><?= $product['productName']; ?></a></b></h5>
                                <p class="card-text">$<?= $product['productPrice']; ?></p>
                                <!-- Send product id as encoded value -->
                                <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />
                                <!-- <p><i class="fas fa-star"></i><span>&#215;</span></p> -->
                                <!-- <button name="btnCart" value="new" class="btn btn-primary">Add to Cart</button> -->

                            </div>
                        </div>
                    </form>

                </div>
            <?php } ?>

        </div>


        <hr>
        <h2>Featured Women Products</h2>
        <div class="row flex-row flex-nowrap overflow-auto">

            <?php
            $sql = "SELECT * FROM Product WHERE genderId= 2 AND productStatus='active'";
            $result = $conn->query($sql);

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
                        <div class="card" style="min-height: 350px">
                            <img src="<?= $images['imagePath'] ?>" alt="Product Image" onerror="this.src='images/placeholder.jpg';" style="width: auto; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><b><a href="productDetail.php?productId=<?php echo $product['productId']; ?>"><?= $product['productName']; ?></a></b></h5>
                                <p class="card-text">$<?= $product['productPrice']; ?></p>
                                <!-- Send product id as encoded value -->
                                <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />
                                <!-- <p><i class="fas fa-star"></i><span>&#215;</span></p> -->
                                <!-- <button name="btnCart" value="new" class="btn btn-primary">Add to Cart</button> -->

                            </div>
                        </div>
                    </form>

                </div>
            <?php } ?>

        </div>
    </div>

    <br><br><br>

    <script>
        $('.stop').carousel({
            interval: false
        });
    </script>



    <?php require_once('footer.html');
    ?>
</body>

</html>