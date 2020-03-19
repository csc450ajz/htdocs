<!DOCTYPE html>
<html lang="en">
<?php
// get navbar
require_once('util/config.html');

//require_once('databaseConnection.php');
require_once('util/db-config.php');

// call getFeaturedProducts() stored procedure
try {
    // execute the stored procedure
    $sql = "CALL getFeaturedProducts();";
    // call the stored procedure
    $result = $conn->query($sql);
} catch (Exception $e) {
    die("Error occurred:" . $e->getMessage());
}


if (isset($_POST['productId'])) {
    echo ($_POST['productId']);

    switch ($_POST['btnCart']) {
        case 'new':
            $productId = $_POST['productId'];
            $userEmail = "admin@admin.com";
            $sql = "INSERT INTO cartitems (userEmail, productId) VALUES (?, ?) ";

            // Set up a prepared statement
            if ($stmt = $conn->prepare($sql)) {
                // Pass the parameters
                $stmt->bind_param("si", $userEmail, $productId);
                if ($stmt->errno) {
                    echo ("stmt prepare() had error.");
                }

                // Execute the query
                $stmt->execute();
                if ($stmt->errno) {
                    echo ("Could not execute prepared statement");
                }

                // Store the result
                $stmt->store_result();
                $totalCount = $stmt->num_rows;

                // Free results
                $stmt->free_result();
                // Close the statement
                $stmt->close();
            } // end if( prepare( ))

            break;
    }
}

?>

<head>
    <title>Sportrader</title>
</head>

<body>
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

    <div class="container">
        <h2 class="text-center">Featured Products</h2>

        <div class="row">

            <?php while ($product = mysqli_fetch_assoc($result)):?>

                <div class="col-sm-3">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

                        <div class="card" >
                            <img src="images/1.jpg" alt="" style="width: auto; height: 200px;">
                            <div class="card-body">
                                <h4 class="card-title"><b><a href="productDetail.php?productId=<?php echo $product['productId']; ?>"><?= $product['productName']; ?></a></b></h4>
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

        <div class="row flex-row flex-nowrap overflow-auto">
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>

            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">
                </div>
            </div>
            <div class="col-3">
                <div class="card card-block">
                    <img class="d-block w-100" src="images/balls.jpg" alt="Balls">

                </div>
            </div>



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
