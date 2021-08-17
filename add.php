<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>



<body>
<?php
//including the database connection file
include_once("connection.php");
?>
<html>
<head>
	<title>Dodaj produkt</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="products.php">Zobacz Produkty</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>

	<form action="add.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr> 
				<td>Price</td>
				<td><input type="decimal" name="price"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="Dodaj"></td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php
if(isset($_POST['Submit']) ) {	
	$name = $_POST['name'];
	$price = $_POST['price'];
		
	// checking empty fields
	if(empty($name) || empty($price)) {
				
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($price)) {
			echo "<font color='red'>Price field is empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		//echo "INSERT INTO products(name, price) VALUES('$name','$price')";
		$result = mysqli_query($mysqli, "INSERT INTO products(name, price) VALUES('$name','$price')");
		
		//display success message
		echo "<font color='green'>Pomyślnie dodano produkt.";
		echo "<br/><a href='products.php'>Powrót</a>";
	}
}
?>
</body>
</html>
