<?php 

	include "int.php";
	include $tpl . "header.php";




		if(isset($_GET["productid"]) && is_numeric($_GET["productid"]) && ($_GET["productid"]) != 0)
		{

			$productid = intval($_GET["productid"]);

			$subavatar = intval($_GET["productid"]);

			if (check($productid) > 0){
				
				$stmt = $con->prepare("SELECT * from products where subavatar = ?");
				$stmt->execute(array($productid));
				$rows = $stmt->fetchall();
				// $r = $stmt->fetch();

				$stmt = $con->prepare("SELECT stock_idi from products where productid = ?");
				$stmt->execute(array($productid));
				$r = $stmt->fetch();
				?>


				<div class="page-discover">

					<div class="page-discover-foreach"> 

						<?php 

						foreach($rows as $row){ ?>

								<img src='admin/uploads/avatars/<?php echo $row["avatar"] ?>'> 
							
								<?php ;} ?>

						<div class="buy">
							
							<div>
								<a href="buy.php?productid=<?php echo $productid; ?>&stid=<?php echo $r['stock_idi']; ?>"><span>buy</span> product</a>
							</div>

						</div>

					</div>

				</div>

			<?php }else{ echo "this id dosent exist";}
		
		}else{echo "this link dosent exist";}


	include $tpl . "footer.php"; 
