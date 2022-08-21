<?php 

	include "int.php";
	include $tpl . "header.php";

		if(isset($_GET["productid"]) && is_numeric($_GET["productid"]) && ($_GET["productid"]) != 0)
		{

			$productN = intval($_GET["productid"]);

			$productid = filter_var($productN, FILTER_SANITIZE_NUMBER_INT); }


			if (check($productid) > 0){

				$rows = fetch_all_where("*", "products", "subavatar", $productid );

				$stmt = $con->prepare("SELECT stock_idi from products where productid = ?");
				$stmt->execute(array($productid));
				$r = $stmt->fetch(); 

				?> 

				<div class="container-fluid">
					<div class="row">
						<div class="page-discover col-12">
							<div class="page-discover-foreach"> 
								<?php 
								
								foreach($rows as $row){ ?>
									<div class="forimg col-lg-12 ">
										<img src='admin/uploads/avatars/<?php echo $row["avatar"] ?>' class="col-md-2 col-6 ">
									</div> 
									
										<?php ;} ?>
										<div class="clear"></div>
								<div class="buy col-md-2 col-sm-3 text-center">
									
									<div>
										<a href="buy.php?productid=<?php echo $productid; ?>&stid=<?php echo $r['stock_idi']; ?>">
											buy product
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<?php } else{ echo "this id dosent exist";}


	include $tpl . "footer.php"; 
