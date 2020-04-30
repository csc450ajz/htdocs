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
        // loop through image array and place in file storage
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
            $fileDestination = '/productImages/'.$fileNameNew;

            // move file to productImages folder
            move_uploaded_file($fileTmpName, ('..'.$fileDestination));

            // query db and insert new productImage record with path
            $sql = "INSERT INTO ProductImage (imagePath, productId) VALUES ('$fileDestination', '$productId');";
            $conn->query($sql);
            echo $conn->error;
            $conn->next_result(); //move to next query
        }
    }


    /* 
    ---------------
    storeProfileImage()
    ---------------
    PARAMS
    $image : Files array of image

    DESCRIPTION
    - takes in FILE array for image
    - stores into userImages folder
    - returns path to be used in storing in db
    */
    function storeProfileImage($image) {
        // get file name and temp storage name
        $fileName = $image['name'];
        $fileTmpName = $image['tmp_name'];

        // get file extension
        $fileExt = explode('.', $fileName);
        $fileExt = strtolower(end($fileExt));

        // create unique file name for image
        $fileNameNew = uniqid('', true).".".$fileExt;

        // designate file destination
        $fileDestination = '../userImages/'.$fileNameNew;

        // move file to productImages folder
        move_uploaded_file($fileTmpName, $fileDestination);

        // return path to file
        return $fileDestination;
    }
?>