<!-- logIn.php - login page for user's
      
    -->



<!DOCTYPE html>
<html>
<?php
require_once('config.html')
?>

<head>
    <title>SporTrader Login</title>
</head>

<body>
    <br />
    <div class="container" style="max-width: 500px; margin: auto;">
        <!-- <h2 align="center">SporTraders</h2> -->
        <img src="images/logo.png" alt="Company Logo" style="border-radius: 50%; display: block; margin: auto; width: 50%;">
        <br />
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="post">
                    <?php echo $message; ?>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="user_email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-success" />
                        <input type="submit" name="signup" value="Signup" class="btn btn-primary" style="float: right;"/>
                    </div>


                    <!-- <div>
                        <label for=""></label>
                    </div> -->
                </form>

            </div>
        </div>
    </div>


</body>

</html>