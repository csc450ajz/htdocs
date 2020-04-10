<?php
$conn->next_result();
$userEmail = $_SESSION['userEmail'];
$userResult = $conn->query("SELECT * FROM User WHERE userEmail='$userEmail';");
$row = mysqli_fetch_assoc($userResult);
$userFName = $row['userFName'];
?>

<head>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    
    <link rel='stylesheet' type='text/css' href='.../style/site.css'>
    <style>
        #profile-nav-img {
            border-radius: 50%;
            margin-right: 10px;
            background-color: black;
        }
        #cartCount {
            font-size: 8pt;
            border-radius: 50%;
            color: white;
            background-color: red;
            border: 1px solid white;
            position: relative;
            right: -40px;
            top: -10px;
            padding: 2px 5px;
        }
    </style>
</head>
    <body>
    <nav class='navbar navbar-expand-lg navbar-dark' style='background-color: black;'>
        <a class='navbar-brand' href='/index.php'>Sportrader</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    
    
            <ul class='navbar-nav mr-auto'>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Browse Products
                    </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <span class='dropdown-item disabled'>Choose a Category:</span>
                        <?PHP 
                            $sql = "SELECT * FROM Category LIMIT 5";
                            $conn->next_result();
                            $catResult = $conn->query($sql);
                            while ($category = mysqli_fetch_assoc($catResult)):
                                $id = $category['categoryId'];
                                $name = $category['categoryName'];
                                echo "<div class='dropdown-divider'></div>";
                                echo "<a class='dropdown-item' href='#'>$name</a>";
                            endwhile;
                        ?>
                        <div class='dropdown-divider'></div>
                        <a href="#" class="dropdown-item">All Products</a>
                    </div>
                </li>
            </ul>
    
            <ul class='navbar-nav ml-auto'>
                <li>
                <?php
                    $cartCount = "";
                    $conn->next_result();
                    $itemResult = $conn->query("SELECT COUNT(productId) FROM CartItems WHERE userEmail='$userEmail';");
                    if ($itemResult) {
                        $cartRow = mysqli_fetch_assoc($itemResult);
                        $itemCount = $cartRow['COUNT(productId)'];
                        if ($itemCount > 0) {
                            $cartCount = "<span id='cartCount'>$itemCount</span>";
                        }
                    }
                    
                    ?>
                    <a class="nav-item nav-text" href="/client/cart/cart.php" data-toggle="tooltip" title="View Cart"><?=$cartCount?><img style="width: 30px; margin: 5px 20px 0 0;" src='/images/cart.png'></a>
                </li>
                
                <li>
                    <div class="dropdown show">
                    <a class="btn btn-md btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="profile-nav-img" src="/<?= $row['userPhotoPath']; ?>" width="30px" height="30px" style="border: 1px solid white;" onerror="this.src='/images/profile.png';">
                        <?=$userFName?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/client/client.php">Profile</a>
                        <a class="dropdown-item" href="/util/logout.php">Logout</a>
                    </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- jQuery CDN links for Bootstrap -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
    
    </body>