<?php 

include "int.php";


		if(isset($_GET["done"]) && is_numeric($_GET["done"])){$done = $_GET["done"];}else{
			$done = 0;
		}

		echo $done;
		$stmt = $con->prepare("SELECT quantity from stock where id = ?");
			$stmt->execute(array($done));
			$feild = $stmt->fetch();

		$stmt = $con->prepare("UPDATE stock set quantity = ?  where id = ? LIMIT 1");
			 	$stmt->execute(array($feild["quantity"] - 1 , $done));
			 	$row = $stmt->rowCount();

			 	ECHO $row . "<br>";

			 	echo "<h1>" . $feild["quantity"] . "</h1>";