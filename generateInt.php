<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>
<!-- This is the php chunck to access the data base -->
<?PHP>
	define("SERVER_NAME","localhost");
	define("DBF_USER_NAME", "root");
	define("DBF_PASSWORD", "mysql");
	define("DATABASE_NAME", "week4");

	//ESTABLISH CONNECTION
	$conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
	$conn->select_db(DATABASE_NAME);

	// Display Table
	$sql = "SELECT * FROM main ";
	//Get data from database
	if(!$result = $conn->query($sql)){
		 die('There was an error running the query [' . $conn->error . ']');
		}
?>

<!--This is the code to generate a number between 0-10   -->
<p> Click This Button to Generate Random Number</p></br>

	<input type ="button" value = "Click Me!" onclick = "genRandomInt();"/>
	<input type ="text" id = "example" name = "example"/>

	<script>
		function genRandomInt() {
			var ranNum = Math.floor(Math.random() * 11);
			document.getElementById('example').value = ranNum;
		}
	</script>
</body>
</html>