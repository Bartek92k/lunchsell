<?php session_start(); ?>
<html>
<head>
	<title>Homepage</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
		Welcome to Lunchsell!
	</div>
	<?php
	if(isset($_SESSION['valid'])) {			
		include("connection.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
	?>
				
		Witaj <?php echo $_SESSION['name'] ?> ! <a href='logout.php'>Wyloguj</a><br/>
		<br/>
		<a href='clients.php'>Klienci</a>
		<br/><br/>
		<br/>
		<a href='products.php'>Produkty</a>
		<br/><br/>
		<br/>
		<a href='lunchsell.php'>Sprzedaż</a>
		<br/><br/>
		<br/>
		<a href='dailylist.php'>Lista dzienna</a>
		<br/><br/>
	<?php	
	} else {
		echo "You must be logged in to view this page.<br/><br/>";
		echo "<a href='login.php'>Login</a> ";
		//| <a href='register.php'>Register</a>";
	}
	?>
	<div id="footer">
		Created by <a href="https://raspinetwork.com" title="Raspinetwork">Raspinetwork</a>
	</div>
</body>
</html>