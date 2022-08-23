<?php

	include "int.php";
	include $tpl . "header.php";

	$stmt = $con->prepare("SELECT * from products where subavatar = 0 order by productid desc ");
	$stmt->execute();
	$rows = $stmt->fetchall();
	?>

	<div class="page-homepage container-fluid">
		<div class="row">

			<h1>shoping</h1>

			<div class="product">

				<?php 
				foreach($rows as $row){ 

				echo " 
				<div class='float col-md-3 col-10'>
					
					<div class='name'>" . $row["name"] . "</div>
						
							<img src='admin/uploads/avatars/" . $row["avatar"] . "' class='col-lg-6 col-5'>
						
					<div class='description mt-3'><a href='discover.php?do=product&productid=" . $row["productid"] . "'> discover the product ?</a></div>
					<div class='price mb-2'>" . $row["price"] . "</div>
					
				</div>";

					}
				?>
				<div class="clear"></div>
			</div>
		</div>

	</div>



<?php include $tpl . "footer.php"; ?>
