<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}

include_once("connection.php");

?>

<html>
<head>
	<title>lista dzienna</title>
</head>

<body>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>
<form action="dailylist.php" method="post" name="dailylist">
		<table width="25%" border="0">
			<tr> 
				<td>Data do wyświetlenia</td>
				<td><input type="date" name="date_show"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Show" value="Pokaz"></td>
			</tr>
		</table>
	</form>
<button onClick="window.print()">Drukuj</button>
<?php
if(isset($_POST['Show'])){

    $date_show=$_POST['date_show'];

$sql_show="SELECT lunchsell.id as ID, clients.name as client, clients.surname as clientsurname, products.name as product, lunchsell.date_from as date_from, lunchsell.date_to as date_to 
FROM lunchsell INNER JOIN clients ON id_client=clients.id 
INNER JOIN products ON id_product=products.id 
WHERE date_from <='$date_show' AND date_to >= '$date_show' ORDER BY clients.saldo DESC";

$result_show = mysqli_query($mysqli, $sql_show);
//echo $sql_show;

echo "<p style='text-align:center'>".$date_show."</p>";
?>

<table style="text-align:center;margin:auto" width='50%' border=0>
		<tr bgcolor='#CCCCCC'>
            <td>ID</td>
			<td>Imie</td>
			<td>nazwisko</td>
			<td>Obiad</td>
		</tr>
<?php
while($res = mysqli_fetch_array($result_show)) {	
    
    echo"<tr>";
    echo "<td>".$res['ID']."</td>";
    echo "<td>".$res['client']."</td>";
    echo "<td>".$res['clientsurname']."</td>";
    echo "<td>".$res['product']."</td>";
    echo"</tr>";

    
 };
 echo"</table>";

};

?>


</body>
</html>
