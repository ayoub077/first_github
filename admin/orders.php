<?php 

session_start();
if(isset($_SESSION["admin"])){

	include "int.php";

	// $stmt = $con->prepare("SELECT * from orders ORDER BY orderid desc");
	// $stmt->execute();
	// $rows = $stmt->fetchall();

	// $stmt = $con->prepare("SELECT quantity from stock");
	// $stmt->execute();
	// $feild = $stmt->fetch();

	$stmt = $con->prepare("SELECT orders.*, products. name
				from orders 
				inner join products on products.productid = orders.order_id");
	$stmt->execute();
	$rowsss = $stmt->fetchall();

	// echo "hello " . $rowsss["name"];

	?>

	
	
<?php 
$do = "";

if(isset($_GET["ord"])){$doo = $_GET["ord"];} else{$doo = "manage";}

$do = filter_var($doo, FILTER_SANITIZE_STRING);

if($do == "manage"){?>
	<div class="page-orders">
		<h1>orders_recieved</h1>
		<table>
			<tr class="tr">
				<td>#orderid</td>
				<td>product-name</td>
				<td>order-size</td>
				<td>name_client</td>
				<td>adress_client</td>
				<td>phone_client</td>
				<td>control</td>
			</tr> 
			
				<?php 
				// foreach($rows as $row ){  
					foreach($rowsss as $rowss){
					echo " 
						<tr>
							<td>" . $rowss['orderid'] . "</td>
							<td>" . $rowss['name'] . "</td>
							<td>" . $rowss['size'] . "</td>
							<td>" . $rowss['client_name'] . "</td>
							<td>" . $rowss['adress'] . "</td>
							<td>" . $rowss['phone'] . "</td>
							<td><a href='?ord=delete&orderid=" . $rowss["orderid"] . "'> <input type='button' value='delete' class='button'></a>
								<a href='?ord=done&doneid=" . $rowss["stock_id"] . "&ordid=" . $rowss["orderid"] . "'><input type='button' value='done' class='button'></a>
							</td>
						</tr> " ;

						

			
			 // } 
			}
			?>



		</table>
	</div>
	<div>
		<?php //echo $feild["quantity"] ?>
	</div>
}
<?php }
elseif($do == "done"){
	if(isset($_GET["doneid"]) && is_numeric($_GET["doneid"])){$done = $_GET["doneid"];}else{
			$done = 0;
		}

		$doneid = filter_var($done, FILTER_SANITIZE_NUMBER_INT);

		if(isset($_GET["ordid"]) && is_numeric($_GET["ordid"])){$orde = $_GET["ordid"];}else{
			$orde = 0;
		}

		$ordid = filter_var($orde, FILTER_SANITIZE_NUMBER_INT);

		$stmt = $con->prepare("SELECT quantity from stock where id = ?");
		$stmt->execute(array($doneid));
		$feild = $stmt->fetch();

		$stmt = $con->prepare("UPDATE stock set quantity = ?  where id = ? LIMIT 1");
		$stmt->execute(array($feild["quantity"] - 1 , $doneid));
		$row = $stmt->rowCount();

		// $stmt = $con->prepare("DELETE from orders where orderid = :orderid");
		// $stmt->bindparam(":orderid", $ordid);
		// $stmt->execute();
		// $count = $stmt->rowcount();

		$count = delete("orders", "orderid", $ordid);

		echo $ordid;


			 	// ECHO $row . "<br>";

			 	// echo "<h1>" . $feild["quantity"] . "</h1>";
}

elseif($do == "delete"){
	// echo "hello";
	if(isset($_GET["orderid"]) && is_numeric($_GET["orderid"])){$order = $_GET["orderid"];}else{
			$order = 0;
		}

		$orderid = filter_var($order, FILTER_SANITIZE_NUMBER_INT);
		/*
		$stmt = $con->prepare("DELETE from orders where orderid = :orderid");
		$stmt->bindparam(":orderid", $orderid);
		$stmt->execute();
		$count = $stmt->rowcount(); */

		$count = delete("orders", "orderid", $orderid);

		if($count > 0){ 
		header("location: orders.php");
		exit();
	}
}

else{echo "sorry, there is no do";}


	// 	if(isset($_GET["orderid"]) && is_numeric($_GET["orderid"])){$orderid = $_GET["orderid"];}else{
	// 		$orderid = 0;
	// 	}

	// 	$stmt = $con->prepare("DELETE from orders where orderid = :orderid");
	// 	$stmt->bindparam(":orderid", $orderid);
	// 	$stmt->execute();
	// 	$count = $stmt->rowcount();

	// 	if($count > 0){ 
	// 	header("location: orders.php");
	// 	exit();
	// }

	// if(isset($_GET["done"]) && is_numeric($_GET["done"])){$done = $_GET["done"];}else{
	// 		$done = 0;
	// 	}

	// 	echo $done;
	// 	$stmt = $con->prepare("SELECT quantity from stock where id = ?");
	// 		$stmt->execute(array($done));
	// 		$feild = $stmt->fetch();

	// 	$stmt = $con->prepare("UPDATE stock set quantity = ?  where stock_id = ? LIMIT 1");
	// 		 	$stmt->execute(array($feild["quantity"] - 1 , $done));
	// 		 	$row = $stmt->rowCount();

	// 		 	echo "<h1>" . $feild["quantity"] . "</h1>";



	$do = "";

	if($do == "orders"){
			if(isset($_GET["done"]) && is_numeric($_GET["done"])){$donee = $_GET["done"];}else{
			$donee = 0;
		}

		$done = filter_var($donee, FILTER_SANITIZE_NUMBER_INT);

		echo "hello world";

		// if(isset($_GET["done"]) && is_numeric($_GET["done"])){$done = $_GET["done"];}else{
		// 	$done = 0;
		// }

		// echo $done;
		// $stmt = $con->prepare("SELECT quantity from stock where id = ?");
		// 	$stmt->execute(array($done));
		// 	$feild = $stmt->fetch();

		// $stmt = $con->prepare("UPDATE stock set quantity = ?  where stock_id = ? LIMIT 1");
		// 	 	$stmt->execute(array($feild["quantity"] - 1 , $done));
		// 	 	$row = $stmt->rowCount();

		// 	 	echo "<h1>" . $feild["quantity"] . "</h1>";
	}


	
	// if(isset($_GET["done"]) && is_numeric($_GET["done"])){$order = 1;}else{$order = 0;}

	// $stmt = $con->prepare("UPDATE stock set quantity = ? ");
	// $stmt->execute(array($feild['quantity'] - 1)); 
	

}
else{ header("location: index.php");
		exit();
		}