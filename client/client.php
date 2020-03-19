<!DOCTYPE html>
<html lang="en">
<?PHP
    require_once('../util/config.html');
    // ensure that the user is logged in, otherwise kick back to login.
    require_once('../util/check-login.php');
    if (!checkLogin()) {
        header("Location: ../login.php");
    }
?>
<head>
    <title>User Page</title>
    
</head>
<body>
    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10">
                <h1>Coming soon -- User Page</h1>
            </div>
        </div>
    </div>
</body>
</html>