<?php 

	session_start();
	$nonavbar = "";
	if(isset($_SESSION["admin"])){
		header("location: dashboard.php");
		exit();
	}

	include "int.php";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$username = $_POST["username"];
		$password = $_POST["password"];
		$hashedpass = sha1($password);


		$stmt = $con->prepare("SELECT username, password from users where username = ? and password = ? and groupid = 1 ");
		$stmt->execute(array($username, $hashedpass));
		$count = $stmt->rowcount();

		if($count > 0){
			$_SESSION["admin"] = $username;
			header("location: dashboard.php");
			exit();
		}else{echo "username or password incorrect.";}

	}

	?>

<div class="page-login">

	<form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
		<label>username</label>
		<input type="text" name="username">
		<label>password</label>
		<input type="password" name="password">
		<input type="submit" value="sign in" class="submit" >
	</form>
	
</div>