<?php 

function check($productid){

	global $con;

	$stmt = $con->prepare("SELECT productid from products where productid = ?");
	$stmt->execute(array($productid));
	$count = $stmt->rowcount();

	return $count;
}