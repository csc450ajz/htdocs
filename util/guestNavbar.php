<head>
    <!--
        This file contains the head elements and toolbar used on all client-facing pages
        Simply call require_once('util/config.php') to add it to a page
    
        Includes:
            - Boostrap CDN
            - Overall site styles (site.css)
            - jQuery (for Bootsrap)
    -->
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
            Browse Categories
          </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='#'>Sporting Gear</a>
                        <a class='dropdown-item' href='#'>Memorabilia</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='#'>Browse by Sport</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='#'>Browse by Type</a>
                        <div class='dropdown-divider'></div>
                        <form class='dropdown-item form my-2 my-lg-0'>
                            <input class='form-control mr-sm-2' type='search' placeholder='Search' aria-label='Search' width='80%'>
                            <button class='btn btn-dark my-2 my-sm-0' type='submit'>Search Products</button>
                        </form>
                    </div>
                </li>
            </ul>
    
            <ul class='navbar-nav ml-auto'>
                <li>
    
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            My Account
          </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='/logIn.php'>Sign In</a>
                        <a class='dropdown-item' href='/client/cart/cart.php'>View Cart</a>
                        <a class='dropdown-item' href='/util/logout.php'>Logout</a>
                        <a class='dropdown-item' href='/signUp.php'>Sign Up</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- jQuery CDN links for Bootstrap -->
    <!-- <script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script> -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
    <!-- <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script> -->
    
    </body>