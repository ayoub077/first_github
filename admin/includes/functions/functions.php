<?php 

function getlatest($select, $table, $select1, $order, $limit = 5){
		global $con;
		
		$getstmt = $con->prepare("SELECT $select from $table where $select1 order by $order desc
		 limit $limit");
		 $getstmt->execute(array($select, $table, $select1, $order, $limit));
		 $rows = $getstmt->fetchall();

		 return $rows;
	}

function countitems($select, $table){
	global $con;

	$stmt = $con->prepare("SELECT count($select) from $table");
	$stmt->execute();
	$count = $stmt->fetchcolumn();

	return $count;
}

function redirect($message, $url, $second = 3){
	
	echo $message;
	header("refresh:$second; url=$url");
	exit();
}



// function fetch_all_where($select, $table, $where, $value){

//  	global $con;

//  	$stmt = $con->prepare("SELECT $select from $table where $where = $value ");
// 	$stmt->execute(array($value));
// 	$rows = $stmt->fetchall();
	
// 	return $rows;

// }

function fetch_all($select, $table){
	global $con; 

	$stmt = $con->prepare("SELECT $select from $table");
	$stmt->execute();
	$rows = $stmt->fetchall();

	return $rows;
}


function fetch_all_where($select, $table, $where, $value){
	global $con; 

	$stmt = $con->prepare("SELECT $select from $table where $where = $value");
	$stmt->execute(array($value));
	$rows = $stmt->fetchall();

	return $rows;
}






function fetch_all_orderBy($select, $table, $orderby){
	global $con; 

	$stmt = $con->prepare("SELECT $select from $table order by $orderby desc");
	$stmt->execute();
	$rows = $stmt->fetchall();

	return $rows;
}


function fetch_all_where_orderBy($select, $table, $where, $value, $orderBy){

 	global $con;

 	$stmt = $con->prepare("SELECT $select from $table where $where = $value order by $orderBy desc ");
	$stmt->execute(array($value));
	$rows = $stmt->fetchall();

	return $rows;

}




function delete($table, $where, $value){
	global $con;

	$stmt = $con->prepare("DELETE from $table where $where = :zproductid ");
	$stmt->bindparam(":zproductid", $value);
	$stmt->execute();
	$count = $stmt->rowcount();

	return $count;
}