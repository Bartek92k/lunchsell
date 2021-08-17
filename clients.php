<?php session_start(); 



if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("connection.php");


//fetching data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM clients ORDER BY saldo DESC");
?>

<html>
<head>
	<title>Homepage</title>
	<style>
		#clients tr:nth-child(even){background-color: #f2f2f2;}
		#clients tr:hover {background-color: #ddd;}
		#clients tr {text-align: center;}
	</style>
</head>

<body>
	<a href="index.php">Home</a> | <a href="addclient.php">Dodaj nowego klienta</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>
	
	<table id="clients" width='50%' border=0>
		<tr bgcolor='#CCCCCC'>
			<td>ID</td>
			<td>Imie</td>
			<td>Nazwisko</td>
			<td>Saldo (pln)</td>
			<td>Działanie</td>
		</tr>
		<?php
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['id']."</td>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['surname']."</td>";
			if($res['saldo']<0){echo '<td style="color:red">'.$res['saldo']."</td>";}elseif($res['saldo']>0){echo '<td style="color:green">'.$res['saldo']."</td>";}else{ echo "<td>".$res['saldo']."</td>";	};
			echo "<td><a href=\"addlunchsell.php?id=$res[id]\">Dodaj zamówienie</a> | <a href=\"editclient.php?id=$res[id]\">Edytuj</a> | <a href=\"deleteclient.php?id=$res[id]\" onClick=\"return confirm('Czy na pewno usunąć?')\">Usuń</a></td>";		
		}
		?>
	</table>	
</body>
</html>
