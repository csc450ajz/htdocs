<?PHP
    /*
    This page defines a series of cart functions, 
    such as adding an item to the cart or removing
    an item from the cart

    Developer: Please be sure to pass in a mysqli
    connection object ($conn) into any function
    call, as this ensures there are not duplicate
    connection objects.
    */
    
    /* 
    ---------------
    addCartItem()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, stores productId in CartItems table with session userEmail
    */
    function addCartItem($itemId, $conn) {
        session_start();
        // make sure the user is logged in, otherwise redirect to login page
        if(isset($_SESSION['userEmail'])) {
            // get productId and userEmail
            $productId = $itemId;
            $userEmail = $_SESSION['userEmail'];
            
            // execute stored procedure
            $sql = "CALL insertCartItem('$productId', '$userEmail');";
            $cartResult = $conn->query($sql);
            $conn->next_result(); // allows following queries to occur
            echo $conn->error;
        } else {
            header("Location: /logIn.php");
            $_SESSION['redirect'] = '/index.php'; // setting this in case we implement a redirect on login page
        }
    }
    /* 
    ---------------
    getCartItems()
    ---------------
    - Checks if user is logged in, otherwise route to login page
    - If logged in, gets all items in Cart at their email address 
    - Returns mysqli_result of query
    */
    function getCartItems($conn) {
        // make sure the user is logged in, otherwise redirect to login page
        if(isset($_SESSION['userEmail'])) {
            $userEmail = $_SESSION['userEmail'];

            // execute stored procedure
            $sql = "CALL getCartItems('$userEmail');";
            $result = $conn->query($sql);
            $conn->next_result();
            echo $conn->error;
            return $result;
        }
    }

?>