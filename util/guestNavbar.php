<head>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    
    <link rel='stylesheet' type='text/css' href='.../style/site.css'>
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
                        while ($category = mysqli_fetch_assoc($catResult)) :
                            $id = $category['categoryId'];
                            $name = $category['categoryName'];
                            echo "<div class='dropdown-divider'></div>";
                            echo "<a class='dropdown-item' href='categoryProducts.php?categoryId=$id'>$name</a>";
                        endwhile;
                        ?>
                        <div class='dropdown-divider'></div>
                        <a href="categoryProducts.php?allProducts" class="dropdown-item">All Products</a>
                    </div>
                </li>
            </ul>
    
            <ul class='navbar-nav ml-auto'>
                <li>
                    <a class="btn btn-md btn-secondary" href="/logIn.php" role="button" id="login">
                        Login
                    </a>
                </li>
                    <span style="color: white; margin: 7px 20px 0;">Or</span>
                <li>
                    <a class="btn btn-md btn-secondary" href="/signUp.php" role="button" id="login">
                        Sign Up
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- jQuery CDN links for Bootstrap -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
    </body>