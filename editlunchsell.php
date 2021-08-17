<?php session_start();

ob_start();

if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}

include_once("connection.php");

$sql_products="SELECT *
FROM products";

$result_products = mysqli_query($mysqli, $sql_products);

?>

<?php
// including the database connection file


if(isset($_POST['update']))
{	
    $id = $_POST['id'];
    $client = $_POST['client'];
	$surname = $_POST['surname'];
	$product = $_POST["product"];
	$date_to = $_POST['date_to'];
	$date_from = $_POST['date_from'];

	// $id = $_POST['id'];
	
	// $name = $_POST['name'];
	// $qty = $_POST['qty'];
	// $price = $_POST['price'];	
	
	// checking empty fields
	if(empty($client) || empty($surname) || empty($product) || empty($date_to) || empty($date_from)) {
				
		if(empty($client)) {
			echo "<font color='red'>imie nie moze byc puste.</font><br/>";
		}
		
		if(empty($surname)) {
			echo "<font color='red'>nazwisko nie moze byc puste.</font><br/>";
		}
		
		if(empty($product)) {
			echo "<font color='red'>obiad nie moze byc puste.</font><br/>";
		}
        if(empty($date_to)) {
			echo "<font color='red'>data do nie moze byc puste.</font><br/>";
		}
        if(empty($date_from)) {
			echo "<font color='red'>data od nie moze byc puste.</font><br/>";
		}		
	} else {	
		//updating the table
        //echo "INSERT INTO lunchsell(id_client, id_product, date_to, date_from ) VALUES('$client','$product','$date_to','$date_from')";
        try{
		$result2 = mysqli_query($mysqli, "UPDATE lunchsell SET id_product='$product', date_to='$date_to', date_from='$date_from' WHERE lunchsell.id='$id'");
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
		
		//redirectig to the display page. In our case, it is view.php
		header("Location: lunchsell.php");
	}
}
?>
<?php
//getting id from url
if(isset($_GET['id'])){
    $id = $_GET['id'];

    //selecting data associated with this particular id
    $result = mysqli_query($mysqli, "SELECT L.id as id, clients.name as client, clients.surname as clientsurname, products.name as product, date_from, date_to 
    FROM lunchsell as L
    INNER JOIN clients ON id_client=clients.id 
    INNER JOIN products ON id_product=products.id 
    WHERE L.id=$id");

    while($res = mysqli_fetch_array($result))
    {
        $id = $res['id'];
        $client = $res['client'];
        $surname = $res['clientsurname'];
        $product = $res['product'];
        $date_to = $res['date_to'];
        $date_from = $res['date_from'];
    }
    ?>
    <html>
    <head>	
        <title>Edytuj zamowienie</title>
    </head>

    <body>
        <a href="index.php">Home</a> | <a href="lunchsell.php">ZOBACZ ZAMOWIENIA</a> | <a href="logout.php">Wyloguj</a>
        <br/><br/>
        
        <form name="form1" method="post" action="editlunchsell.php">
            <table border="0">
                <tr> 
                    <td>ID</td>
                    <td><input type="text" name="id" readonly="readonly" value="<?php echo $id;?>"></td>
                </tr>
                <tr> 
                    <td>Imie</td>
                    <td><input type="text" name="client" readonly="readonly" value="<?php echo $client;?>"></td>
                </tr>
                <tr> 
                    <td>Nazwisko</td>
                    <td><input type="text" name="surname" readonly="readonly" value="<?php echo $surname;?>"></td>
                </tr>
                <tr> 
                    <td>Obiad</td><td>
                        <select name="product">
                            <?php while ($row = $result_products->fetch_array(MYSQLI_ASSOC)) {
                            echo "<option value='" . $row['id'] . "'>'" . $row['name'] . " ".$row['price']." '</option>";}?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Data od</td>
                    <td><input type="text" name="date_from" value="<?php echo $date_from;?>"></td>
                </tr>
                <tr> 
                    <td>Data do</td>
                    <td><input type="text" name="date_to" value="<?php echo $date_to;?>"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                    <td><input type="submit" name="update" value="Aktualizuj"></td>
                </tr>
            </table>
        </form>
    </body>
    </html><?php
};?>
