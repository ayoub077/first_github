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