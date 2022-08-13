<?php 
include "admin/config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = $_POST["username"];

$stmt = $con->prepare("INSERT into test(name)values(:zname)  ");
					$stmt->execute(array(
						"zname" => $name));
					$count = $stmt->rowcount();

				echo	$message =  $count . " product insert";
				}

				?>


<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
				
				<!-- <input type="hidden" name="productid" value="<?php //echo $productid ?>"> -->
				<!-- <input type="hidden" name="stockid" value="<?php //echo $row['stock_idi'] ?>"> -->
				<label>username</label>
				<input type="text" name="username">
				
				<input type="submit" class="submit" value="Send">
			</form>		