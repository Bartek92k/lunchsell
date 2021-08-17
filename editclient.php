<?php session_start();
ob_start();

if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("connection.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	
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
	} else {	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE clients SET name='$name', surname='$surname', saldo='$saldo' WHERE clients.id=$id");
		
		//redirectig to the display page. In our case, it is view.php
		header("Location: clients.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM clients WHERE clients.id=$id");

while($res = mysqli_fetch_array($result))
{
	$name = $res['name'];
	$surname = $res['surname'];
	$saldo = $res['saldo'];
}
?>
<html>
<head>	
	<title>edytuj klienta</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="clients.php">Zobacz liste klientów</a> | <a href="logout.php">Wyloguj</a>
	<br/><br/>
	
	<form name="form1" method="post" action="editclient.php">
		<table border="0">
			<tr> 
				<td>Imie</td>
				<td><input type="text" name="name" value="<?php echo $name;?>"></td>
			</tr>
			<tr> 
				<td>Nazwisko</td>
				<td><input type="text" name="surname" value="<?php echo $surname;?>"></td>
			</tr>
			<tr> 
				<td>Saldo</td>
				<td><input type="decimal" name="saldo" value="<?php echo $saldo;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Aktualizuj"></td>
			</tr>
		</table>
	</form>
</body>
</html>
