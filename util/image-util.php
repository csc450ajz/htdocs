<?PHP 

    /* 
    ---------------
    storeProductImages()
    ---------------
    PARAMS
    $images : Files array of images
    $productId : productId of product
    $conn : current db connection (prevents duplicate connections)

    DESCRIPTION
    - takes in FILE array for images
    - stores into productImages folder
    - stores image path in db at productId param
    */
    function storeProductImage($images, $productId, $conn) {

        for ($i = 0; $i < sizeof($images['name']); $i++) {
            // get file name and temp storage name
            $fileName = $images['name'][$i];
            $fileTmpName = $images['tmp_name'][$i];

            // get file extension
            $fileExt = explode('.', $fileName);
            $fileExt = strtolower(end($fileExt));

            // create unique file name for image
            $fileNameNew = uniqid('', true).".".$fileExt;

            // designate file destination
            $fileDestination = '../productImages/'.$fileNameNew;

            // move file to productImages folder
            move_uploaded_file($fileTmpName, $fileDestination);

            // query db and insert new productImage record with path
            $sql = "INSERT INTO ProductImage (imagePath, productId) VALUES ('$fileDestination', '$productId');";
            $conn->query($sql);
            echo $conn->error;
            $conn->next_result(); //move to next query
        }
    }
?>