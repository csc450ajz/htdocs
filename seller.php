<!DOCTYPE html>
<html lang="en">
<?php
	// check that user is logged in, if not kick to login page
	require_once('util/check-login.php');
	if(!checkLogin()) {
		header("Location: logIn.php");
	}
	//Database Connection
	include('util/db-config.php');

	//Get Navigation Bar
	require_once('util/config.html');

	//Get Sold Items
	function getSoldItems($conn) {
        //Check User LogIn
        if(isset($_SESSION['userEmail'])) {
            $userEmail = $_SESSION['userEmail'];

            //Execute Stored Procedure
            $sql = "CALL getSoldItems('$userEmail');";
            $result = $conn->query($sql);
            $conn->next_result();
            echo $conn->error;
            return $result;
        }
    }//End of Function
	$soldResult = getSoldItems($conn);

	//Get Selling Items
	function getSellingItems($conn) {
        //Check User LogIn
        if(isset($_SESSION['userEmail'])) {
            $userEmail = $_SESSION['userEmail'];

            //Execute Stored Procedure
            $sql = "CALL getSellingItems('$userEmail');";
            $result = $conn->query($sql);
            $conn->next_result();
            echo $conn->error;
            return $result;
        }
    }//End of Function
	$sellingResult = getSellingItems($conn);

	//Get Purchased Items
	function getPurchasedtems($conn) {
        //Check User LogIn
        if(isset($_SESSION['userEmail'])) {
            $userEmail = $_SESSION['userEmail'];

            //Execute Stored Procedure
            $sql = "CALL getPurchasedItems('$userEmail');";
            $result = $conn->query($sql);
            $conn->next_result();
            echo $conn->error;
            return $result;
        }
    }//End of Function
	$purchasedResult = getPurchasedtems($conn);

?>


<head>
    <title>Seller</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-4">Products</h3>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-sold-tab" data-toggle="tab" href="#nav-sold" role="tab" aria-controls="nav-sold" aria-selected="true">Sold</a>
                    <a class="nav-item nav-link" id="nav-selling-tab" data-toggle="tab" href="#nav-selling" role="tab" aria-controls="nav-selling" aria-selected="false">My Products</a>
					<a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">Purchase History</a>
                </div>
            </nav>

			<!--  Sold Tab ---------------------------------------------------------------------------->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-sold" role="tabpanel" aria-labelledby="nav-sold-tab">
					
                    <?php
					if($soldResult){
						while ($orderItems = mysqli_fetch_assoc($soldResult)){
							//echo $orderItems['productId'];
							$sql = "SELECT * FROM Product WHERE productId= ".$orderItems['productId'];
							$result2 = $conn->query($sql);
							echo $conn->error;
							while ($product = mysqli_fetch_assoc($result2)) {
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
													<!--<p><i>Purchased by: <?= $product['userEmail'] ?></i></p> -->
												</div>
											</div>
										</div>
									</div>
									<hr />
                            </div>
                    <?php
                            }
						}
					}
					?>
                </div>


				<!--  Selling Tab ------------------------------------------------------------------>
                <div class="tab-pane fade" id="nav-selling" role="tabpanel" aria-labelledby="nav-selling-tab">
				<?php
					if($sellingResult){
						while ($sellingItems = mysqli_fetch_assoc($sellingResult)){
							//echo $sellingItems['productId'];
							$sql = "SELECT * FROM Product WHERE productId= ".$sellingItems['productId'];
							$result2 = $conn->query($sql);
							echo $conn->error;
							while ($product = mysqli_fetch_assoc($result2)) {
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
												</div>
											</div>
										</div>
									</div>
									<hr />
                            </div>
                    <?php
                            }
						}
					}
					?>
                </div>

				<!--  Purchased Tab --------------------------------------------------------------->
                <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
				<?php
					if($purchasedResult){
						while ($orderItems = mysqli_fetch_assoc($purchasedResult)){
							//echo $orderItems['productId'];
							$sql = "SELECT * FROM Product WHERE productId= ".$orderItems['productId'];
							$result2 = $conn->query($sql);
							echo $conn->error;
							while ($product = mysqli_fetch_assoc($result2)) {
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
					}
					?>

                </div>
            </div>
        </div>
    </div>
	<?php
    require_once('footer.html');

    ?>

</body>
</html>