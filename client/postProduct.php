<?php
// if user is already logged in, redirect to profile page
include('../util/check-login.php');
if (!checkLogin()) {
    header('Location: /logIn.php');
}

// create db connection 
include('../util/db-config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check that a max of 5 files were passed
    if (sizeof($_FILES['productImages']['name']) < 6) {
        // gather form values
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $size = $_POST['size'];
        $brand = $_POST['brand'];
        $condition = $_POST['condition'];
        $color = $_POST['color'];
        $gender = $_POST['gender'];
        $userEmail = $_SESSION['userEmail'];

        // run query and store result (which is productId of product just inserted)    
        $sql = "CALL addProduct('$title', '$description', '$price', '$condition', '$size', 'active', '$category', '$brand', '$gender', '0.0', '$userEmail', '$color');";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $conn->next_result();
        // DEBUG
        //echo $conn->error;
        //echo $sql;

        // store the images in file system and db
        require_once('../util/image-util.php');
        storeProductImage($_FILES['productImages'], $row['productId'], $conn);
    } else {
        echo "Too many files selected!";
    }
}

?>

<!DOCTYPE html>
<html>
<?php
include('../util/config.html');
?>

<head>
    <title>Sportrader - Sell a Product</title>
</head>

<body>
<div class="container">
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-8">
                <h1>Sell a Product</h1>
            </div>
        </div>
        <div class="row justify-content-sm-center">
            <div class="col col-sm-10 col-md-8 col-lg-8">
                <form method="post" action="<?php $self ?>" enctype="multipart/form-data" id="product-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Product Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="A catchy, informative title for your product." maxlength="100" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option></option>
                                <?PHP 
                                $sql = "SELECT * FROM Category";
                                $conn->next_result();
                                $result = $conn->query($sql);
                                while ($category = mysqli_fetch_assoc($result)):
                                    $id = $category['categoryId'];
                                    $name = $category['categoryName'];
                                    echo "<option value='$id'>$name</option>";
                                endwhile;
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description">Product Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your product in as much detail as possible!" maxlength="254" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="price">Product Price</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" name="price" id="price" placeholder="14.99" required>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="size">Product Size</label>
                            <input type="text" name="size" class="form-control" id="size" placeholder="e.g. Size M or 3x3" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" class="form-control" id="brand" placeholder="e.g. Nike, Adidas" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="condition">Condition</label>
                            <select class="form-control" id="condition" name="condition" required>
                                <option>New</option>
                                <option>Like New</option>
                                <option>Used - Good</option>
                                <option>Used - Fair</option>
                                <option>Used - Worn</option>
                                <option>Broken/For Parts</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="color">Color</label>
                            <input type="text" name="color" class="form-control" id="color" placeholder="Grey" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="1">Men's</option>
                                <option value="2">Women's</option>
                                <option value="3">Other/None</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="productImage">Upload Images of Your Product! (Limit 5)</label>
                            <input type="file" class="form-control-file" name="productImages[]" accept=".jpg,.JPEG,.JPG,.jpeg,.png,.PNG,.gif,.GIF" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Post for sale!</button>
                </form>
            </div>
        </div>
    </div>
     <!-- jQuery CDN links for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        // function prevents more than 5 files from being uploaded
        jQuery('#product-form').submit(function(){
            var $fileUpload = $("input[type='file']");
            if (parseInt($fileUpload.get(0).files.length) > 5) {
                alert("You can only upload a maximum of 5 files");
                return false;
            }
            return true;
        });
    </script>
</body>

</html>