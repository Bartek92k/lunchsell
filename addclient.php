<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>


<?php
//including the database connection file
include_once("connection.php");

?>
<html>
<head>
	<title>Dodaj klienta</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="clients.php">Zobacz klientów</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>

	<form action="addclient.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr> 
				<td>Imie</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr> 
				<td>Nazwisko</td>
				<td><input type="text" name="surname"></td>
			</tr>
			<tr> 
				<td>Saldo</td>
				<td><input type="decimal" name="saldo"></td>
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
if((isset($_POST['Submit'])) ) {	
	$name = $_POST['name'];
	$surname = $_POST['surname'];
    $saldo = $_POST['saldo'];
		
	// checking empty fields
	if(empty($name) || empty($surname) || empty($saldo)) {
				
		if(empty($name)) {
			echo "<font color='red'>imie nie moze byc puste.</font><br/>";
		}
		
		if(empty($surname)) {
			echo "<font color='red'>nazwisko nie moze byc puste.</font><br/>";
		}
        if(empty($saldo)) {
			echo "<font color='red'>saldo nie moze byc puste.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>powrót</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
        //echo "INSERT INTO clients(name, surname, saldo ) VALUES('$name','$surname','$saldo')";
		//echo "INSERT INTO clients(name, surname, saldo ) VALUES('$name','$surname','$saldo')";
		$result = mysqli_query($mysqli, "INSERT INTO clients(name, surname, saldo ) VALUES('$name','$surname','$saldo')");
		
		//display success message
		echo "<font color='green'>Pomyślnie dodano klienta.";
		echo "<br/><a href='clients.php'>Powrót</a>";
	}
}
?>
</body>
</html>
