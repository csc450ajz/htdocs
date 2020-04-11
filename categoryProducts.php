<!DOCTYPE html>
<html lang="en">
<?php
// get navbar
require_once('util/config.php');

// if categoryId is passed in POST, display products based on the category
if (isset($_GET['categoryId'])) {
    //Store categoryId
    $categoryId = $_GET['categoryId'];

    //Call getCategoryBasedProducts function
    $productsResult = getCategoryBasedProducts($conn, $categoryId);

    //Call getCategoryDetail function
    $categoryResult = getCategoryDetail($conn, $categoryId);
    $category = mysqli_fetch_assoc($categoryResult);

    //Else if all product is chosen, display all products
} elseif (isset($_GET['allProducts'])) {
    //Call getAllProducts function
    $productsResult = getAllProducts($conn);

    //Set cateogry Name to All Products since it is not in the database
    $category['categortName'] = 'All Products';
}

// if productId is passed in POST, add to cart
if (isset($_POST['productId'])) {
    require_once("client/cart/cart-utility.php");
    addCartItem($_POST['productId'], $conn);
}


//Function for getting products based on category
//Param: $conn, categryId
//Returns: result
function getCategoryBasedProducts($conn, $categoryId)
{
    $sql = "SELECT * FROM Product WHERE categoryId='$categoryId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

//Function for getting all products
//Param: $conn
//Returns: result
function getAllProducts($conn)
{
    $sql = "SELECT * FROM Product";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}


//Function for getting category detail
//Param: $conn, categryId
//Returns: result
function getCategoryDetail($conn, $categoryId)
{
    $sql = "SELECT categoryName FROM Category WHERE categoryId='$categoryId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
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

    .product {
        min-height: 400px;
    }

    @media only screen and (max-width: 400px) {
        .product {
            min-height: 350px;
        }
    }
</style>
<?php
require_once(('util' . $navbar));
?>

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

        <h2 class="text-center"><?= $category['categoryName'] ?> Results</h2>


        <div class="row">

            <?php
            if (mysqli_num_rows($productsResult) > 0) {
                while ($product = mysqli_fetch_assoc($productsResult)) {
                    $id = $product['productId'];
                    $sql = "SELECT imagePath FROM ProductImage WHERE productId='$id' LIMIT 1;";
                    $conn->next_result();
                    $imageResult = $conn->query($sql);
                    $images = mysqli_fetch_assoc($imageResult);


            ?>

                    <div class="col-xs-8 col-md-6 col-lg-3 mb-4">
                        <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                            <!-- col-md-3 col-sm-6 mb-4 -->
                            <div class="card product">
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

            <?php }
            } else {
                echo '<h4 class="text-center" style="color: red">Sorry, 0 results found for this category</h4>';
            } ?>

        </div>

        <hr>

    </div>

    <br><br>



    <?php require_once('footer.html');
    ?>
</body>

</html>