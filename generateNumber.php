<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>
<?PHP
	//POST VARIABLES
	//if(isset($_POST["ID"])){
		$ID = $_POST["ID"];
	//}
	//if(isset($_POST["Name"])){
		$Name = $_POST["Name"];
	//}
	//if(isset($_POST["Ingredients"])){
		$Ingredients = $_POST["Ingredients"];
	//}
	//if(isset($_POST["Price"])){
		$Price = $_POST["Price"];
	//}

	//define("SERVER_NAME","sql200.byethost.com");
	//define("DBF_USER_NAME", "b11_23604134_week3");
	//define("DBF_PASSWORD", "Jeffrey2930441");
	//define("DATABASE_NAME", "week4");
	
	define("SERVER_NAME","localhost");
	define("DBF_USER_NAME", "root");
	define("DBF_PASSWORD", "mysql");
	define("DATABASE_NAME", "week4");

	//ESTABLISH CONNECTION
	$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
	$conn->select_db(DATABASE_NAME);

	//Add New Data
	$newArray = array(
	array($ID,$Name,$Ingredients,$Price)
	);
	foreach($newArray as $array1) {   
		$sql = "INSERT INTO main (ID, Name, Ingredients, Price) "
			. "VALUES ('" . $array1[0] . "', '"
			. $array1[1] . "', '" 
			. $array1[2] . "', '" 
			. $array1[3] . "')";

	if ($conn->query($sql) === TRUE) {
 
	}
   }

	// Display Table main
	$sql = "SELECT * FROM main ";
	//Get data from database
	if(!$result = $conn->query($sql)){
		 die('There was an error running the query [' . $conn->error . ']');
		}
		echo '<table>';
		echo '<tr>';
		echo '<th>ID</th>';
		echo '<th>Name</th>';
		echo '<th>Ingredients</th>';
		echo '<th>Price</th>';
		echo'</tr>';
	// Display the list of titles
		while($row = $result->fetch_assoc()){
			echo '<tr>';
			echo '<th id = inside><strong>' . $row['ID'] . '</strong></th>';
			echo '<th id = inside>'. $row['Name'] . '</th>';
			echo '<th id = inside>' . $row['Ingredients'] . '</th>';
			echo '<th id = inside>'. $row['Price'] . '<br/>' . '</th>' ;
		 }
		echo'<table>';
		echo'<br/>';
?>
	<a href="presentation.php">Home</a> </br>
	<a href="edit.php">Manager View</a>


</body>
</html>