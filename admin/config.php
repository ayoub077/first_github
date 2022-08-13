<?php 

	$dsn = "mysql:host=localhost;dbname=sarashop";
	$user = "root";
	$pass = "";

	try{
		$con = new PDO($dsn, $user, $pass);

		// echo "you connect";
	}

	catch(PDOException $e){
		echo "wrong" . $e->getmessage();
	}