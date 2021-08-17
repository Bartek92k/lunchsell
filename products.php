<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("connection.php");

//fetching data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC");
?>

<html>
<head>
	<title>Homepage</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="add.php">Dodaj nowy produkt</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>
	
	<table width='80%' border=0>
		<tr bgcolor='#CCCCCC'>
			<td>Nazwa</td>
			<td>cena</td>
			<td>Działanie</td>
		</tr>
		<?php
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['price']."</td>";	
			echo "<td><a href=\"edit.php?id=$res[id]\">Edytuj</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Czy na pewno usunąć?')\">Usuń</a></td>";		
		}
		?>
	</table>	
</body>
</html>
