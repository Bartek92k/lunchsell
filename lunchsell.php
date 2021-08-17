<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("connection.php");

$today = date('Y-m',time());

$month = date('m', strtotime($today));
$year = date('Y', strtotime($today));
//echo "<p>".$today."</p>";
//fetching data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT lunchsell.id as ID, clients.id as client_id, clients.name as client, clients.saldo as saldo, clients.surname as clientsurname, products.name as product, date_from, date_to 
FROM lunchsell 
INNER JOIN clients ON id_client=clients.id 
INNER JOIN products ON id_product=products.id 
WHERE ((MONTH(date_from) = $month OR month(date_to) = $month)
AND (year(date_from) = $year OR year(date_to) = $year)) 
ORDER BY clients.saldo DESC");

if(isset($_POST['Show'])){
    $date_show = $_POST['date_show'];
	$month = date('m', strtotime($date_show));
	$year = date('Y', strtotime($date_show));
    $result = mysqli_query($mysqli, 
	// "SELECT lunchsell.id as ID, clients.id as client_id, clients.name as client, clients.saldo as saldo, clients.surname as clientsurname, products.name as product, date_from, date_to 
    // FROM lunchsell 
    // INNER JOIN clients ON id_client=clients.id 
    // INNER JOIN products ON id_product=products.id 
    // ORDER BY clients.saldo DESC");

	"SELECT lunchsell.id as ID, clients.id as client_id, clients.name as client, clients.saldo as saldo, clients.surname as clientsurname, products.name as product, date_from, date_to 
	FROM lunchsell 
	INNER JOIN clients ON id_client=clients.id 
	INNER JOIN products ON id_product=products.id 
	WHERE ((MONTH(date_from) = $month OR month(date_to) = $month)
	AND (year(date_from) = $year OR year(date_to) = $year))    
	ORDER BY clients.saldo DESC");


	echo "<p>".$date_show."</p>";
	// echo "<p>".$date_show->format(M)."</p>";
	// echo "<p>".$date_show->format(Y)."</p>";
}
?>
<html>
<head>
	<title>Sprzedaz obiadow</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="addlunchsell.php">Dodaj nowe zamówienie</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>

    <form action="lunchsell.php" method="post" name="lunchsell">
		<table width="25%" border="0">
			<tr> 
				<td>Data do wyświetlenia</td>
				<td><input type="month" placeholder="np. 2021-07" name="date_show"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Show" value="Pokaz"></td>
			</tr>
		</table>
	</form>
	
	<table width='50%' border=0>
		<tr bgcolor='#CCCCCC'>
            <td>ID</td>
			<td>Imie</td>
			<td>Nazwisko</td>
			<td>Obiad</td>
			<td>Saldo</td>
			<td>Data od</td>
			<td>Data do</td>
			<td>Działanie</td>
		</tr>
		<?php
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['client_id']."</td>";
			echo "<td>".$res['client']."</td>";
			echo "<td>".$res['clientsurname']."</td>";
			echo "<td>".$res['product']."</td>";
			if($res['saldo']<0){echo '<td style="color:red">'.$res['saldo']."</td>";}elseif($res['saldo']>0){echo '<td style="color:green">'.$res['saldo']."</td>";}else{ echo "<td>".$res['saldo']."</td>";	};	            
			echo "<td>".$res['date_from']."</td>";
			echo "<td>".$res['date_to']."</td>";
			echo "<td><a href=\"editlunchsell.php?id=$res[ID]\">Edytuj</a> | <a href=\"deletelunchsell.php?id=$res[ID]\" onClick=\"return confirm('Czy na pewno usunąć?')\">Usuń</a></td>";		
		}
		?>
	</table>	
</body>
</html>
