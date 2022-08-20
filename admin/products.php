 <?php 
	
	session_start();
	if(isset($_SESSION['admin'])){

		include "int.php";

		$stmt = $con->prepare("SELECT * from stock");
		$stmt->execute();
		$stocks = $stmt->fetchall();

		$do = "";

		if(isset($_GET["do"])){$do = $_GET["do"];}else{$do = "manage";}

		if($do == "manage"){
			$stmt = $con->prepare("SELECT * from products where subavatar = 0 order by productid desc");
			$stmt->execute();
			$rows = $stmt->fetchall();




			?>

			<div class="page-products-manage">

					<h1>welcome in manage page</h1>

				<table>
					<tr>
						<td>#id</td>
						<td>name</td>
						<td>photo</td>
						<td>description</td>
						<td>price</td>
						<td>control</td>
					</tr>
					
						<?php
						

						foreach($rows as $row){

							

							
							echo "<tr>
										<td>" . $row["productid"] . "</td>
										<td>" . $row["name"] . "</td>
										<td> <img src='uploads/avatars/" . $row["avatar"] . "'></td>
										<td>" . $row["description"] . "</td>
								 		<td>" . $row["price"] . "</td>
								 		<td><a href='?do=edit&productid=" . $row["productid"] . "'><input type='button' value='edit' class='edit' ></a>
								 			<a href='?do=picture&pic-id=" . $row["productid"] . "'><input type='button' value='photo?' class='photo'></a>

								 			<a href='?do=delete&productid=" . $row["productid"] ."'><input type='button' value='delete' class='delete' ></a>
								 			<a href='?do=show&productid=" . $row["productid"] . "'><input type='button' value='show' class='show' ></a>
								 		</td>
								</tr>";
								
						}

						
						?>
					
				</table>

				<a href="?do=add" class="add"><input type="button" value="+ add new product"></a>
				
			</div>
		<?php }

		elseif($do == "add"){?>

			<div class="page-products-add">

				<h1>add product</h1>

				<form action="?do=insert" method="POST" enctype="multipart/form-data">
					<label>name</label>
					<input type="text" name="name">
					<label>description</label>
					<input type="text" name="description">
					<label>price</label>
					<input type="text" name="price">
					<label>photo</label>
					<input type="file" name="avatar">
					<select name='stock_idi'>
						<optgroup></optgroup>
						<?php
							foreach($stocks as $stock){
								echo "<option value='" . $stock['id'] . "'>" . $stock["name"] . "</option>";
							}
						 ?>
						
					</select>
					<input type="submit">
				</form>
				
			</div>

		<?php }

		elseif($do == "insert"){

			if($_SERVER["REQUEST_METHOD"] == "POST"){


				$avatar = $_FILES["avatar"];

				$avatarname = $_FILES["avatar"]["name"];
				$avatarsize = $_FILES["avatar"]["size"];
				$avatartmp = $_FILES["avatar"]["tmp_name"];
				$avatartype = $_FILES["avatar"]["type"];

				$avatarallowedextension = array("jpeg", "jpg", "png", "gif");

				// $avatarextension = strtolower(end(explode(".", $_FILES["avatar"]["name"])));

				$avatarextension = explode(".", $_FILES["avatar"]["name"]); 
				$avatarextension1 = end($avatarextension);
			    $avatarextension2 = strtolower($avatarextension1);
			    // $avatarextension1 = end($avatarextension2);



				$name = $_POST["name"];
				$description = $_POST["description"];
				$price = $_POST["price"];
				$stock_idi = $_POST["stock_idi"];

				// echo "$avatarname and $avatarsize and $avatartmp and $avatartype and $avatarextension2";

				// echo $name . $description . $price;

				$formerrors = array();

				if(empty($name)){$formerrors[] = "name cant be empty";}
				if(empty($description)){$formerrors[] = "descrioption cant be empty";}
				if(empty($price)){$formerrors[] = "price cant be empty";}
				if(! empty($avatarname) && ! in_array($avatarextension2, $avatarallowedextension)){$formerrors[] = "this extension is <bold>not allowed</bold";}
				if(empty($avatarname)){$formerrors[] = "avatar is <bold>required</bold>";}

				if($avatarsize > 4194304){$formerrors[] = "avatar cant be larger than <strong>4MB</strong";}

				foreach($formerrors as $error){echo $error . "<br>";} 

				if(empty($formerrors)){

					$avatar = rand(0, 100000) . "_" . $avatarname;

					move_uploaded_file($avatartmp, "uploads\avatars\\" . $avatar);

					$stmt = $con->prepare("INSERT into products(name, description, price, avatar, stock_idi)values(:zname, :zdescription, :zprice, :zavatar, :zstock_idi)  ");
					$stmt->execute(array(
						"zname" => $name,
						"zdescription" => $description,
						"zprice" => $price,
						"zavatar" => $avatar,
						"zstock_idi" => $stock_idi));
					$count = $stmt->rowcount();

					$message =  $count . " product insert"; 

					// redirect($message, "products.php");

				}



			}else{echo "you cant browse this page directly.";}

			
				

				
				
		}

		elseif($do == "edit"){

			if(isset($_GET["productid"])){$productid = $_GET["productid"];}else{$productid = 0;}

			$stmt = $con->prepare("SELECT * from products where productid = ?");
			$stmt->execute(array($productid));
			$product = $stmt->fetch();

			?>
			<div class="page-products-edit">

				<h1>edit product</h1>
				<form action="?do=update" method="POST" enctype="multipart/form-data">

					<input type="hidden" name="productid" value="<?php echo $product["productid"] ?>">
					<label>name</label>
					<input type="text" name="name" value="<?php echo $product["name"] ?>">
					<label>description</label>
					<input type="text" name="description" value="<?php echo $product["description"] ?>">
					<label>price</label>
					<input type="text" name="price" value="<?php echo $product["price"] ?>">
					<label>photo</label>
					<img src="uploads/avatars/<?php echo $product["avatar"] ?>" style="height:150PX">
					<span>
						<input type="button" value="change photo?">
						<input type="file" name="avatar">

					 </span>
					
					<input type="submit">
				</form>
			</div>

		<?php }

		elseif($do == "update"){

			if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){

				$avatar = $_FILES["avatar"];

				$avatarname = $_FILES["avatar"]["name"];
				$avatarsize = $_FILES["avatar"]["size"];
				$avatartmp  = $_FILES["avatar"]["tmp_name"];
				$avatartype = $_FILES["avatar"]["type"];

				$avatarallowextension = array("jpeg", "jpg", "png", "gif");

				//$avatarextension = strtolower(end(explode(".", $_FILES["avatar"]["name"])));

				$avatarextension1 = explode(".", $avatarname);
				$avatarextension2 = end($avatarextension1);
				$avatarextension3 = strtolower($avatarextension2);

				$productid = $_POST["productid"];
				$name = $_POST["name"];
				$description = $_POST["description"];
				$price = $_POST["price"];


				$formerrors = array();

				if(empty($name)){$formerrors[] = "name cant be empty";}
				if(empty($description)){$formerrors[] = "descrioption cant be empty";}
				if(empty($price)){$formerrors[] = "price cant be empty";}
				if(! empty($avatarname) && ! in_array($avatarextension3, $avatarallowextension)){$formerrors[] = "this extension is not allowed";}
				//if(empty($avatarname)){$formerrors[] = "photo is required";}
				if($avatarsize > 4194304){$formerrors[] = "avatar can not be larger than <strong>4MB</strong>";}

				foreach($formerrors as $error){
					echo $error . "<br>";

					$message = '';
					redirect($message, "?do=edit&productid=$productid", 3);
				} 

				 if(empty($formerrors)){

				$avatar = rand(0, 100000) . "_" . $avatarname;

				move_uploaded_file($avatartmp, "uploads\avatars\\" . $avatar);

					$stmt = $con->prepare("UPDATE products set name = ?, description = ?, price = ?, avatar = ? where productid = ? ");
					$stmt->execute(array($name, $description, $price, $avatar, $productid));
					$count = $stmt->rowcount();

					$message =  $count . " record update";

					redirect($message, "?do=edit&productid=$productid");
				} }else{echo "you cant browse this page directly.";}

		}

		elseif($do == "picture"){

			if(isset($_GET["pic-id"]) && is_numeric($_GET["pic-id"])){$picid = intval($_GET["pic-id"]);}else{$picid = 0;}

			
			?>

			<div class="page-products-picture">
				
				<h1>new picture</h1>
				<form action="?do=insert-pic" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="picid" value="<?php echo $picid ?>">
					<label>add picture</label>
					<input type="file" name="avatar">
					
					<input type="submit">
				</form>
			</div>

		<?php }

		elseif($do == "insert-pic"){
			if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){  
				
				$avatar = $_FILES["avatar"];

				$avatarname = $_FILES["avatar"]["name"];
				$avatarsize = $_FILES["avatar"]["size"];
				$avatartmp  = $_FILES["avatar"]["tmp_name"];
				$avatartype = $_FILES["avatar"]["type"]; 
				

				$picid = $_POST["picid"];

				//echo $picid;
				
				$avatarallowedextension = array("jpeg", "jpg", "png", "gif");

				$avatarextension = explode(".", $_FILES["avatar"]["name"]); 
				$avatarextension1 = end($avatarextension);
			    $avatarextension2 = strtolower($avatarextension1);

			    $formerrors = array();

			    if(! empty($avatarname) && ! in_array($avatarextension2, $avatarallowedextension)){$formerrors[] = "this extension is <bold>not allowed</bold";}
				if(empty($avatarname)){$formerrors[] = "avatar is <bold>required</bold>";}

				if($avatarsize > 4194304){$formerrors[] = "avatar cant be larger than <strong>4MB</strong";}

				foreach($formerrors as $error){echo $error . "<br>";} 

				if(empty($formerrors)){

					$avatar = rand(0, 100000) . "_" . $avatarname;

					move_uploaded_file($avatartmp, "uploads\avatars\\" . $avatar);

					$stmt = $con->prepare("INSERT into products(avatar, subavatar)values(:zavatar, :zsub_avatar)  ");
					$stmt->execute(array(
						"zavatar" => $avatar,
						"zsub_avatar" => $picid));
					$count = $stmt->rowcount();

					$message =  $count . " image insert";

					redirect($message, "products.php");



				} 


				
			}else{echo "sorry, you cant";}
		}

		elseif($do == "show"){

			if(isset($_GET["productid"]) && is_numeric($_GET["productid"])){$productid = intval($_GET["productid"]);}else{$productid = -1 ;}

			$stmt = $con->prepare("SELECT * from products where subavatar = ?");
			$stmt->execute(array($productid));
			$rows = $stmt->fetchall();

			?>
			<div class="page-products-show">
				<div class='contain'>
					<?php foreach($rows as $row){echo "
					 
					 	<img src='uploads/avatars/" . $row["avatar"] . "'> 				
					 " ;}
					 ?>
				 </div>
			</div>
		<?php }

		elseif($do == "delete"){
			if(isset($_GET["productid"])){$productid = $_GET["productid"];}
			else{$productid = 0;}

			$stmt = $con->prepare("DELETE from products where productid = :zproductid ");
			$stmt->bindparam(":zproductid", $productid);
			$stmt->execute();
			$count = $stmt->rowcount();

			$message =  $count . " record delete";

			redirect($message, "products.php");
		}

		else{echo "oops, there is no such page $do";}

	}else{
		header("location: index.php");
		exit();
	}