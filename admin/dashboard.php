 <?php 

 	 session_start();
	 if(isset($_SESSION["admin"])){
	 	include "int.php"; ?>

	 	<div class="page-dashboard">
	 		<h1>welcome in dashboard</h1>
	 		<div class="content">
	 			<div>
	 				total products is:<br>
	 				<strong><?php echo countitems("productid", "products"); ?></strong>

	 			</div>
	 			<div>
	 				total in stock is:<br>
	 				<strong><?php echo countitems("id", "stock") ?></strong> 	 			
	 			</div>
	 			<div>
	 				total orders is:<br>
	 				<strong><?php echo countitems("orderid", "orders") ?></strong>
	 			</div>	 			
	 		</div>
	 		<div class="latest1">
	 			<h3>5 latest products:</h3><br>
	 			<?php 

	 			$thelatest = getlatest("*", "products", "subavatar = 0", "productid");

	 			foreach($thelatest as $latest){echo "

	 				<div class='div1'>" . $latest["name"] . "</div> 
	 				<div class='div2'><img src='uploads/avatars/" . $latest["avatar"] . "'></div><br>";}

	 			

	 				// $stmt = $con->prepare("SELECT name from products order by productid desc limit 3");
	 				// $stmt->execute();
	 				// $stmt->fetchall();
	 			?>
	 			<div class="clear"></div>
	 		</div>

	 		<div class="latest2">
	 			<h3>all orders:</h3> <br>
	 			<?php

	 			$latests = getlatest("*", "orders", "orderid != 0", "orderid");
	 			foreach($latests as $latest){
	 				echo $latest["client_name"] . ": <div class='span'>order-id is:<span class='span1'> " . $latest['orderid'] . "</span></div><br> ";
	 			}
	 			?>
	 		</div>
	 		<div class="clear"></div>
	 		
	 	</div>
	 	<div class="clear"></div>
		

		<?php /// include 'logout.php';

		// echo "<a href='logout.php'>logout<a>";

	 }else{
		 header("location: index.php");
		 exit();
	 }

