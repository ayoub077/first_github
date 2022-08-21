<?php 

	include "int.php";
	include $tpl . "header.php";




		if(isset($_GET["productid"]) && is_numeric($_GET["productid"]) && ($_GET["productid"]) != 0)
		{

			$productN = intval($_GET["productid"]);

			$productid = filter_var($productN, FILTER_SANITIZE_NUMBER_INT);


			// $subavatar = intval($_GET["productid"]);

			if (check($productid) > 0){
				/*
				$stmt = $con->prepare("SELECT * from products where subavatar = ?");
				$stmt->execute(array($productid));
				$rows = $stmt->fetchall();  
				// $r = $stmt->fetch(); */

				$rows = fetch_all_where("*", "products", "subavatar", $productid );


				
				$stmt = $con->prepare("SELECT stock_idi from products where productid = ?");
				$stmt->execute(array($productid));
				$r = $stmt->fetch(); 

				// echo $r = fetch_where("stock_idi", "products", "productid", $productid)[0]["stock_idi"];

				// echo "hello: " . $r["stock_idi"];

				// echo "hello: " . $r["stock_idi"];

				// print_r($r);
				?> 


				<!-- <div class="page-discover">

					<div class="page-discover-foreach"> 

						<?php 

					//	foreach($rows as $row){ ?>

								<img src='admin/uploads/avatars/<?php// echo $row["avatar"] ?>'> 
							
								<?php ;} ?>

						<div class="buy">
							
							<div>
								<a href="buy.php?productid=<?php //echo $productid; ?>&stid=<?php //echo $r['stock_idi']; ?>"><span>buy</span> product</a>
							</div>

						</div>

					</div>

				</div> -->


				<div class="container-fluid">
					<div class="row">
						<div class="page-discover col-12">
							<div class="page-discover-foreach"> 
								<?php 
								// echo 'hello world' . $r['stock_idi'] . $productid;
								foreach($rows as $row){ ?>
									<div class="forimg col-lg-12">
										<img src='admin/uploads/avatars/<?php echo $row["avatar"] ?>' class="col-md-2 col-6 ">
									</div> 
									
										<?php ;} ?>
										<div class="clear"></div>
								<div class="buy col-2 text-center">
									
									<div>
										<a href="buy.php?productid=<?php echo $productid; ?>&stid=<?php echo $r['stock_idi']; ?>">
											<!-- <span>buy</span> -->
											buy product</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<?php } else{ echo "this id dosent exist";}
		
		
		// else{echo "this link dosent exist";}


	include $tpl . "footer.php"; 
