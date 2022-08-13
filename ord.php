<?php 
include "admin/config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$username = $_POST['username'];
// $password = $_POST['password'];
// $email = $_POST['email'];
// $fullname = $_POST['fullname'];

echo $username; 
//. $password;
// $stmts = $con->prepare("INSERT into orders(productid, client_name) values(:zproductid, :zname"); 

// 					// echo $productid . "<br>" . $name . "<br>" . $size . "<br>" . $adress . "<br>" . $phone . '<br>' . $productid . "<br>" . $stockid ;
// 			$stmts->execute(array(
// 				"zname" => $name,
// 				"zproductid" => $productid)); 

// 			$count = $stmts->rowcount(); 

// 			echo $count ; 

/*$stmts = $con->prepare("INSERT into users(username, password, email, fullname) values(:zusername, :zpassword, :zemail, :zfullname"); 
			$stmts->execute(array(
				"zusername" => $username,
				"zpassword" => $password,
				"zemail" => $email,
				"zfullname" => $fullname)); 

			$count = $stmts->rowcount(); */

			$stmt = $con->prepare("INSERT into test(name) values(:zname)"); 
			$stmt->execute(array(
				"zname" => $username)); 

			$count = $stmt->rowcount(); 

			echo "<br>status is: " . $count ; 

// $stmt = $con->prepare("INSERT into test(name)values(:zname)  ");
// 					$stmt->execute(array(
// 						"zname" => $username));
// 					$count = $stmt->rowcount();

// 				echo	$message =  $count . " product insert";

}
?>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
				
				<!-- <input type="hidden" name="productid" value="<?php //echo $productid ?>"> -->
				<!-- <input type="hidden" name="stockid" value="<?php //echo $row['stock_idi'] ?>"> -->
				<label>username</label>
				<input type="text" name="username">
				
				<input type="submit" class="submit" value="Send">
			</form>			

			<!-- <label>password</label>
				<input type="text" name="password">
				<label>email</label>
				<input type="text" name="email" placeholder="email">
				<label>fullname</label>
				<input type="text" name="fullname"> -->