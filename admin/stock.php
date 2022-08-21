<?php 
	
	session_start();
	if(isset($_SESSION['admin'])){

		include "int.php";

		$do = "";

		if(isset($_GET["do"])){$doo = $_GET["do"];}else{$doo = "manage";}

		$do = filter_var($doo, FILTER_SANITIZE_STRING);

		if(isset($_GET["done"]) && is_numeric($_GET["done"])){$donee = $_GET["done"] ;}
		else{$donee = 0;}

		$done = filter_var($donee, FILTER_SANITIZE_NUMBER_INT);

		if($do == "manage"){

			$rows = fetch_all_orderBy("*", "stock", "id");

			if($done != 0){
			$stmt = $con->prepare("SELECT quantity from stock where stock_id = ?");
			$stmt->execute(array($done));
			$feild = $stmt->fetch();
			}


			?>

			<div class="page-stock-manage">

				<h1>manage stock</h1>
				<table>
					<tr>
						<td>#id</td>
						<td>name</td>
						<td>quantity</td>
						<td>price</td>
						<td>control</td>
					</tr>
					
						<?php
						

						foreach($rows as $row){
							echo "<tr>
										<td>" . $row["id"] . "
										<td>" . $row["name"] . "</td>
										<td>" . $row["quantity"] . "
								 		<td>" . $row["price"] . "</td>
								 		<td><a href='?do=edit&productid=" . $row["id"] . "'><input type='button' value='edit' class='edit' ></a>
								 		<a href='?do=delete&productid=" . $row["id"] . "'><input type='button' value='delete' class='delete' ></a></td>
								</tr>";
						}

						
						?>
					
				</table>
				<a href="?do=add" class="add"><input type="button" value="+ add new product"</a>
				
			</div>

		<?php }

		elseif($do == "add"){?>

			<div class="page-stock-add">

				<form action="?do=insert" method="POST" enctype="multipart/form-data">
					<label>name</label>
					<input type="text" name="name">
					<label>quantity</label>
					<input type="text" name="quantity">
					<label>price</label>
					<input type="text" name="price">
					<label>photo</label>
					<input type="file" name="avatar">
					<input type="submit">
				</form>
				
			</div>

		<?php }

		elseif($do == "insert"){

			if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){


				$avatar = $_FILES["avatar"];

				$avatarnamee = $_FILES["avatar"]["name"];
				$avatarsizee = $_FILES["avatar"]["size"];
				$avatartmpe = $_FILES["avatar"]["tmp_name"];
				$avatartypee = $_FILES["avatar"]["type"];

				$avatarname = filter_var($avatarnamee, FILTER_SANITIZE_STRING);
				$avatarsize = filter_var($avatarsizee, FILTER_SANITIZE_STRING);
				$avatartmp = filter_var($avatartmpe, FILTER_SANITIZE_STRING);
				$avatartype = filter_var($avatartypee, FILTER_SANITIZE_STRING);

				$avatarallowedextension = array("jpeg", "jpg", "png", "gif");


				$avatarextension = explode(".", $_FILES["avatar"]["name"]); 
				$avatarextension1 = end($avatarextension);
			    $avatarextension2 = strtolower($avatarextension1);
			    

				$namee = $_POST["name"];
				$quantitye = $_POST["quantity"];
				$pricee = $_POST["price"];

				$name = filter_var($namee, FILTER_SANITIZE_STRING);
				$quantity = filter_var($quantitye, FILTER_SANITIZE_STRING);
				$price = filter_var($pricee, FILTER_SANITIZE_STRING);


				$formerrors = array();

				if(empty($name)){$formerrors[] = "name cant be empty";}
				if(empty($quantity)){$formerrors[] = "quantity cant be empty";}
				if(empty($price)){$formerrors[] = "price cant be empty";}
				if(! empty($avatarname) && ! in_array($avatarextension2, $avatarallowedextension)){$formerrors[] = "this extension is <bold>not allowed</bold";}
				if(empty($avatarname)){$formerrors[] = "avatar is <bold>required</bold>";}

				if($avatarsize > 4194304){$formerrors[] = "avatar cant be larger than <strong>4MB</strong";}

				foreach($formerrors as $error){
					echo $error;

					$message = "";

					redirect($message, "?do=add");
				} 

				if(empty($formerrors)){

					$avatar = rand(0, 100000) . "_" . $avatarname;

					move_uploaded_file($avatartmp, "uploads\avatars\\" . $avatar);

					$stmt = $con->prepare("INSERT into stock(name, quantity, price, avatar)values(:zname, :zquantity, :zprice, :zavatar)  ");
					$stmt->execute(array(
						"zname" => $name,
						"zquantity" => $quantity,
						"zprice" => $price,
						"zavatar" => $avatar));
					$count = $stmt->rowcount();

					$message =  $count . " product insert";

					redirect($message, "stock.php");

				}



			}else{echo "you cant browse this page directly.";}
		}

		elseif($do == "edit"){

			if(isset($_GET["productid"])){$productN = $_GET["productid"];}else{$productN = 0;}

			$productid = filter_var($productN, FILTER_SANITIZE_NUMBER_INT);

			$stmt = $con->prepare("SELECT * from stock where id = ?");
			$stmt->execute(array($productid));
			$product = $stmt->fetch();

			?>
			<div class="page-stock-edit">
				<form action="?do=update" method="POST">

					<input type="hidden" name="productid" value="<?php echo $product["id"] ?>">
					<label>name</label>
					<input type="text" name="name" value="<?php echo $product["name"] ?>">
					<label>quantity</label>
					<input type="text" name="quantity" value="<?php echo $product["quantity"] ?>">
					<label>price</label>
					<input type="text" name="price" value="<?php echo $product["price"] ?>">
					
					<input type="submit">
				</form>
			</div>

		<?php }

		elseif($do == "update"){

			if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){

				$producte = $_POST["productid"];
				$namee = $_POST["name"];
				$quantitye = $_POST["quantity"];
				$pricee = $_POST["price"];

				$productid = filter_var($producte, FILTER_SANITIZE_NUMBER_INT);
				$name = filter_var($namee, FILTER_SANITIZE_STRING);
				$quantity = filter_var($quantitye, FILTER_SANITIZE_NUMBER_INT);
				$price = filter_var($pricee, FILTER_SANITIZE_STRING);


				$formerrors = array();

				if(empty($name)){$formerrors[] = "name cant be empty";}
				if(empty($quantity)){$formerrors[] = "quantity cant be empty";}
				if(empty($price)){$formerrors[] = "price cant be empty";}

				foreach($formerrors as $error){echo $error . "<br>";} 

				if(empty($formerrors)){

					$stmt = $con->prepare("UPDATE stock set name = ?, quantity = ?, price = ? where id = ? ");
					$stmt->execute(array($name, $quantity, $price, $productid));
					$count = $stmt->rowcount();

					$message =  $count . " record update";

					redirect($message, "stock.php");
				}


			}else{echo "you cant browse this page directly.";}

		}

		elseif($do == "delete"){
			if(isset($_GET["productid"])){$productN = $_GET["productid"];}
			else{$productN = 0;}

			$productid = filter_var($productN, FILTER_SANITIZE_NUMBER_INT);


			$count = delete("stock", "id", $productid);

			$message =  $count . " record delete";

			redirect($message, "stock.php");
		}

		else{echo "oops, there is no such page $do";}


	} else{echo "sorry";}