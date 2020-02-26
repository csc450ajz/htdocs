<!-- productDetail.php - product detail page
      
    -->


<!DOCTYPE html>
<html>
<?php
require_once('config.html')
?>

<head>
    <title>Product Detail</title>
</head>

<body>
    <br>

    <!-- Page Content -->
    <div class="container-fluid">

        <div class="wrapper row">

            <div class="col-md-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                    <img class="img-fluid" src="images/1.jpg" alt="">
                    </div>
                    <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">Product reviews goes here</div>
                    <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">Place for buyer to message seller</div>
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">Description</a>
                        <a class="nav-item nav-link" id="nav-reviews-tab" data-toggle="tab" href="#nav-reviews" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews</a>
                        <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#nav-message" role="tab" aria-controls="nav-message" aria-selected="false">Message Seller</a>
                    </div>
                </nav>

                
            </div>

            <div class="col-md-4">
                <h3 class="my-3">Product Name</h3>
                <p>Brand: Nike</p>
                <p>Availability: In Stock</p>
                <br>
                <h5>Price: $40</h5>

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
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">Product description goes here</div>
                    <div class="tab-pane fade" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">Product reviews goes here</div>
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