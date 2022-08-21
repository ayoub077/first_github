<?php 

function check($productid){

	global $con;

	$stmt = $con->prepare("SELECT productid from products where productid = ?");
	$stmt->execute(array($productid));
	$count = $stmt->rowcount();

	return $count;
}



 function fetchall_OrderBy($table, $where, $value, $orderBy = null){

 	global $con;

 	$stmt = $con->prepare("SELECT $select from $table where $where = $value order by $orderBy desc ");
	$stmt->execute(array($value));
	$rows = $stmt->fetchall();

	return $rows;

}


 function fetch_all_where($select, $table, $where, $value){

 	global $con;

 	$stmt = $con->prepare("SELECT $select from $table where $where = $value ");
	$stmt->execute(array($value));
	$rows = $stmt->fetchall();
	// $row = $stmt->fetch();
	// $rows = $stmt->fetchall();

	return $rows;
	// return $row[$select];

}



/*
 function fetch_where($select, $table, $where, $value){

 	global $con;

 	$stmt = $con->prepare("SELECT $select from $table where $where = $value ");
	$stmt->execute(array($value));
	// $rows = $stmt->fetchall();
	$row = $stmt->fetch();
	// $rows = $stmt->fetchall();

	// return $rows;
	// return $row[$select];
	return $row;

}  */