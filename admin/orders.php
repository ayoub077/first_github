<?php 

session_start();
if(isset($_SESSION["admin"])){

	include "int.php";

	$stmt = $con->prepare("SELECT orders.*, products. name
				from orders 
				inner join products on products.productid = orders.order_id");
	$stmt->execute();
	$rowsss = $stmt->fetchall();

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

			}
			?>



		</table>
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

		$count = delete("orders", "orderid", $ordid);

		header("location: orders.php");
}

elseif($do == "delete"){
	
	if(isset($_GET["orderid"]) && is_numeric($_GET["orderid"])){$order = $_GET["orderid"];}else{
			$order = 0;
		}

		$orderid = filter_var($order, FILTER_SANITIZE_NUMBER_INT);

		$count = delete("orders", "orderid", $orderid);

		if($count > 0){ 
		header("location: orders.php");
		exit();
	}
}

else{echo "sorry, there is no do";}

	$do = "";

	if($do == "orders"){
			if(isset($_GET["done"]) && is_numeric($_GET["done"])){$donee = $_GET["done"];}else{
			$donee = 0;
		}

		$done = filter_var($donee, FILTER_SANITIZE_NUMBER_INT);

		echo "hello world";

	}
}
else{ header("location: index.php");
		exit();
		}