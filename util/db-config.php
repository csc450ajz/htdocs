<?php
    /*
        db-config.php
        Creates connection to MySQL database.

        Developers: Please replace this file with your localhost
        credentials in order to access your local db.
    */

    // define credentials for db
    define("SERVER_NAME","localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "root");
    define("DATABASE_NAME", "sportrad_sportrader");

	// establish connection
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
    $conn->select_db(DATABASE_NAME);
    
    // DEBUG test the connection
    $sql = "SELECT * FROM User";
    $result = $conn -> query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "User Email: " . $row["userEmail"];
        }
    } else {
        echo "0 results";
    }
?>