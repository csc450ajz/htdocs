<!DOCTYPE html>
<html lang="en">
<?php
require_once('util/config.html')
?>

<head>
    <title>index.php</title>
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
            <?php 
               $query = "SELECT TOP 4 FROM product ORDER BY product.productHit DESC" 
            ?>

            <div class="col-sm-3">

                <div class="card">
                    <img src="images/1.jpg" alt="" style="width: auto; height: 200px;">
                    <div class="card-body">
                        <h4 class="card-title"><b>Basketball</b></h4>
                        <p class="card-text">Price: $20.00</p>
                        <a href="#" class="btn btn-primary">Add to Order</a>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">

                <div class="card">
                    <img src="images/1.jpg" alt="" style="width: auto; height: 200px;">
                    <div class="card-body">
                        <h4 class="card-title"><b>Basketball</b></h4>
                        <p class="card-text">Price: $20.00</p>
                        <a href="#" class="btn btn-primary">Add to Order</a>
                    </div>
                </div>

            </div>

            <div class="col-sm-3">

                <div class="card">
                    <img src="images/1.jpg" alt="" style="width: auto; height: 200px;">
                    <div class="card-body">
                        <h4 class="card-title"><b>Basketball</b></h4>
                        <p class="card-text">Price: $20.00</p>
                        <a href="#" class="btn btn-primary">Add to Order</a>
                    </div>
                </div>

            </div>

            <div class="col-sm-3">

                <div class="card">
                    <img src="images/1.jpg" alt="" style="width: auto; height: 200px;">
                    <div class="card-body">
                        <h4 class="card-title"><b>Basketball</b></h4>
                        <p class="card-text">Price: $20.00</p>
                        <a href="#" class="btn btn-primary">Add to Order</a>
                    </div>
                </div>

            </div>


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




</body>

</html>