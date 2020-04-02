<!DOCTYPE html>
<html lang="en">
<?php
//require_once('databaseConnection.php');
include('util/db-config.php');

// if productId is passed in POST, add to cart
if (isset($_POST['productId'])) {
    require_once("util/cart-utility.php");
    addCartItem($_POST['productId'], $conn);
}


// get navbar
require_once('util/config.html');


// call getFeaturedProducts() stored procedure
$sql = "CALL getFeaturedProducts();";
$result = $conn->query($sql);
?>

<head>
    <title>Sportrader</title>
</head>
<style>
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

<body>


    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Search Products</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <!-- Search form -->
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark" type="button" value="search">Search</button>
            </div>
        </div>
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
        <h2 class="text-center">Featured Products</h2>

        <div class="row">

            <?php while ($product = mysqli_fetch_assoc($result)) : ?>

                <div class="col-xs-8 col-md-6 col-lg-3">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                        <div class="card featured">
                            <img src="images/placeholder.jpg" alt="" style="width: auto; height: 200px;">
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
 <?php while ($product = mysqli_fetch_assoc($result)) {

                ?>

            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
               
                    <div class="col-4">
                        <div class="card card-block">
                            <img class="d-block w-100" src="images/balls.jpg" alt="Balls">
                            <h5>$<?= $product['productPrice']; ?></h5>

                            <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />
                            <!-- <button name="btnCart" value="new" class="btn btn-primary">Add to Cart</button> -->
                        </div>
                    </div>

            </form>
        <?php } ?>

        </div>


        <hr>
        <h2>Featured Women Products</h2>
        <div class="row flex-row flex-nowrap overflow-auto">

            <?php
            $sql = "SELECT * FROM product WHERE product.genderId=2";
            $result = $conn->query($sql);

            while ($product = mysqli_fetch_assoc($result)) {

            ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                    <div class="col-4">
                        <div class="card card-block">
                            <img class="d-block w-100" src="images/balls.jpg" alt="Balls">
                            <h5>$<?= $product['productPrice']; ?></h5>

                            <input type="hidden" name="productId" value="<?= $product['productId']; ?>" />
                            <!-- <button name="btnCart" value="new" class="btn btn-primary">Add to Cart</button> -->
                        </div>
                    </div>
                </form>
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