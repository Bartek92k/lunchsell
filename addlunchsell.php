<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
include_once("connection.php");

$sql_clients="SELECT *
FROM clients";

$sql_products="SELECT *
FROM products";

//$result_clients = $conn->query($sql_clients);
$result_clients = mysqli_query($mysqli, $sql_clients);

$result_products = mysqli_query($mysqli, $sql_products);
//$resul_products = $conn->query($sql_products);



//-----------------------------------------------body---------------------------------------
?>
<html>
<head>
	<title>Add Lunchsell</title>
</head>

<body>
<?php
//including the database connection file


?>
<html>
<head>
	<title>Add lunchsell</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="lunchsell.php">Zobacz zamowienia</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>

	<form action="addlunchsell.php" method="post" name="addlunchsell">
		<table width="25%" border="0">
			<tr> 
				<td>klient</td><td>
					<?php if(isset($_GET['id'])){
						$id=$_GET['id'];
						?> <input type="decimal" name="client" readonly value="<?php echo $id ?>">  <?php
					}else{?>
						<select name="client">
							<?php while ($row = $result_clients->fetch_array(MYSQLI_ASSOC)) {
							echo "<option value='" . $row['id'] . "'>'" . $row['id'] . " " . $row['name'] . " ".$row['surname']." saldo: ".$row['saldo']."'</option>";}?>
						</select>
					<?php } ?>
				</td>
			</tr>
			<tr> 
				<td>produkt</td><td>
                    <select name="product">
                        <?php while ($row = $result_products->fetch_array(MYSQLI_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>'" . $row['name'] . " ".$row['price']." '</option>";}?>
                    </select></td>
			</tr>
			<tr> 
				<td>data_od</td>
				<td><input type="date" name="date_from"></td>
			</tr>
            
			<tr> 
				<td>data_to</td>
				<td><input type="date" name="date_to"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="dodaj zamowienie"></td>
			</tr>
		</table>
	</form>
</body>
</html>




<?php
if((isset($_POST['Submit'])) && ($_POST['Submit']=='dodaj zamowienie')) {	
	$client = $_POST["client"];
	$product = $_POST["product"];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
		
	// checking empty fields
	if(empty($date_from) || empty($date_to) ) {
				
		if(empty($date_from)) {
			echo "<font color='red'>data od nie moze byc puste.</font><br/>";
		}
		
		if(empty($date_to)) {
			echo "<font color='red'>date do nie moze byc puste.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>powrót</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
        //echo "INSERT INTO clients(name, surname, saldo ) VALUES('$name','$surname','$saldo')";
		//echo "INSERT INTO lunchsell(id_client, id_product, date_to, date_from ) VALUES('$client','$product','$date_to','$date_from')";
		$result = mysqli_query($mysqli, "INSERT INTO lunchsell(id_client, id_product, date_to, date_from ) VALUES('$client','$product','$date_to','$date_from')");

		$interval = date_create($date_to)->diff(date_create($date_from));
		$diffInDays = ($interval->d)+1;

		// $days_sell = round(($date_to - $date_from) / (60 * 60 * 24)) ;

		//round($datediff / (60 * 60 * 24));

		$sql_decrease_saldo = "UPDATE clients as c
		set c.saldo= c.saldo - ((select price from products as p where p.id = $product)*$diffInDays)
		where c.id = $client";
		$result2= mysqli_query($mysqli, $sql_decrease_saldo);
		
		//display success message
		echo "<font color='green'>Pomyślnie dodano zamówienie";
		echo "<br/><a href='lunchsell.php'>Powrót</a>";
	}
}
?>
</body>
</html>
