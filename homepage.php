
<?php

/*	include "int.php";
	include $tpl . "header.php";

	$stmt = $con->prepare("SELECT * from products where subavatar = 0 order by productid desc ");
	$stmt->execute();
	$rows = $stmt->fetchall();


	?>

	<div class="page-homepage">

		<h1>shoping</h1>

		<div class="product">

			<?php 
				foreach($rows as $row){ 
					echo " 
						<div class='float'>
							<div class='name'>" . $row["name"] . "</div>
							<img src='admin/uploads/avatars/" . $row["avatar"] . "'>
							<div class='description'><a href='discover.php?do=product&productid=" . $row["productid"] . "'> discover the product ?</a></div>
							<div class='price'>" . $row["price"] . "</div>
						</div>";
							}
			?>

			<div class="clear"></div>
			
		</div>
		
	</div>



<?php include $tpl . "footer.php"; ?>
*/



















	include "int.php";
	include $tpl . "header.php";

	$stmt = $con->prepare("SELECT * from products where subavatar = 0 order by productid desc ");
	$stmt->execute();
	$rows = $stmt->fetchall();

	// $rows = fetchall("*", "products", "subavatar", 0, "productid");

	// foreach($rows as $row ){
	// 	echo $row["avatar"];
	// }

	?>

	<div class="page-homepage container-fluid">
		<div class="row">

			<h1>shoping</h1>

			<div class="product">

				<?php 
				foreach($rows as $row){ 
				/*echo " 
				<div class='float'>
					<div class='name'>" . $row["name"] . "</div>
					<img src='admin/uploads/avatars/" . $row["avatar"] . "'>
					<div class='description'><a href='discover.php?do=product&productid=" . $row["productid"] . "'> discover the product ?</a></div>
					<div class='price'>" . $row["price"] . "</div>

				</div>"; */


				echo " 
				<div class='float col-lg-4 col-12'>
					
					<div class='name'>" . $row["name"] . "</div>
						
							<img src='admin/uploads/avatars/" . $row["avatar"] . "' class='col-lg-8 col-8'>
						
					<div class='description mt-3'><a href='discover.php?do=product&productid=" . $row["productid"] . "'> discover the product ?</a></div>
					<div class='price mb-2'>" . $row["price"] . "</div>
					
				</div>";

				// echo "<div>" . $row["description"] . "</div>";
					}
				?>
				<div class="clear"></div>
			</div>
		</div>

	</div>



<?php include $tpl . "footer.php"; ?>
