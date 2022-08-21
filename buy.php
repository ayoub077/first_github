<?php 
	
	include "int.php";
	include $tpl . "header.php";


	
	if(isset($_GET["productid"]) && is_numeric($_GET["productid"])){$productN = intval($_GET["productid"]);}else{$productN = 0;}

	if(isset($_GET["stid"]) && is_numeric($_GET["stid"])){$stockN = intval($_GET["stid"]);}else{$stockN = 0;}

	$productid = filter_var($productN, FILTER_SANITIZE_NUMBER_INT);
	$stockid   = filter_var($stockN, FILTER_SANITIZE_NUMBER_INT);




	$stmt = $con->prepare("SELECT * from products where productid = ?");
	$stmt->execute(array($productid));
	$row  = $stmt->fetch();



?>

<div class="page-buy">

	<div>
		<div class="div1">

			<form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
				<input type="hidden" name="productid" value="<?php echo $productid ?>">
				<label>your name</label>
				<input type="text" name="name">
				<label>the size exist: 40 | 41 | 42 | 43 | 44</label>
				<input type="text" name="size" placeholder="example: 40/41">
				<label>your adress</label>
				<input type="text" name="adress">
				<label>number phone</label>
				<input type="text" name="phone">
				<input type="submit" class="submit" value="Send">
			</form>

		</div>

		<div class="div2">
			<img src="admin/uploads/avatars/<?php echo $row["avatar"]; ?>" class="d-lg-block d-none">
		</div>

	</div>

</div>

<?php 

		if($_SERVER["REQUEST_METHOD"] == "POST"){

			$nameF  	 = $_POST["name"];
			$adressF 	 = $_POST["adress"];
			$phoneF  	 = $_POST["phone"];
			$sizeF   	 = $_POST["size"];
			$productF  = $_POST["productid"];

			$name = filter_var($nameF, FILTER_SANITIZE_STRING);
			$adress = filter_var($adressF, FILTER_SANITIZE_STRING);
			$phone = filter_var($phoneF, FILTER_SANITIZE_NUMBER_INT);
			$size = filter_var($sizeF, FILTER_SANITIZE_STRING);
			$productid = filter_var($productF, FILTER_SANITIZE_STRING);


			
			$formerrors = array();

			if(empty($name)){$formerrors[] = "Name can not be empty";}

			if(empty($adress)){$formerrors[] = "Adress can not be empty";}

			if(empty($phone)){$formerrors[] = "Phone can not be empty";}

			if(empty($size)){$formerrors[] = "Size can not be empty";}

			if(!empty($phone) && !is_numeric($phone)){$formerrors[] = "phone must be numbers";}

			foreach($formerrors as $error){echo "<div style='background-color:#E30909; color:white; margin:1%; padding:1%; '>" . $error . "</div>" ;}

			if(empty($formerrors)){ 

				if(is_numeric($phone)){
					$stmt = $con->prepare("INSERT into orders(productid, client_name, size, adress, phone, order_id
						, stock_id
						) values
						(:zproductid, :zname, :zsize, :zadress, :zphone, :zorder_id, :zstock_id)");

					
					$stmt->execute(array(
						"zproductid" => $productid,
						"zname" => $name,
						"zsize" => $size,
						"zadress" => $adress,
						"zphone" => $phone,
						"zorder_id" => $productid,
						"zstock_id" => $stockid 
							)
							); 

						$count = $stmt->rowcount(); 

							 	if($count > 0){?>
							<div class="thanks">
								<div class="div">thank you for buy our product, we will call you.</div>
							</div>
						<?php 
						 header("refresh:2;url=homepage.php");
						 exit(); 
						}
				}
 
			} 
		} 
	include $tpl . "footer.php";
?>