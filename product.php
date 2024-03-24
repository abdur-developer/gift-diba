<?php include 'includes/session.php'; ?>
<?php
	$conn = $pdo->open();

	$slug = $_GET['product'];

	try{
		 		
	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
	    $stmt->execute(['slug' => $slug]);
	    $product = $stmt->fetch();
		
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	//page view
	$now = date('Y-m-d');
	if($product['date_view'] == $now){
		$stmt = $conn->prepare("UPDATE products SET counter=counter+1, total_view=total_view+1 WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid']]);
	}
	else{
		$stmt = $conn->prepare("UPDATE products SET counter=1, total_view=total_view+1, date_view=:now WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid'], 'now'=>$now]);
	}

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9 bg-success">
	        		<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
		            <div class="row" style="margin: 2px; padding: 2px;">
		            	<div class="col-sm-6" style="margin-bottom: 3px;">
		            		<img src="<?php echo (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?php echo $product['photo']; ?>">
		            		<br><br>
							<!-- ========= -->
							<?php
							if(isset($_SESSION['user'])){
								$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
								$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$product['prodid']]);
								$row = $stmt->fetch();
								if($row['numrows'] < 1){ ?>
									<form class="form-inline" id="productForm">
										<div class="form-group">
											<input type="hidden" name="quantity" id="quantity" value="1">
											<input type="hidden" name="id" value="<?php echo $product['prodid']; ?>">
											<button type="submit" class="btn btn-primary btn-lg btn-flat add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</form>
									<?php }else{ ?>
										<a class="btn btn-success btn-lg btn-flat" style="color: #fff" href="cart_view.php"><i class="fa fa-bag"></i> Buy now</a>
									<?php }
							}else{ 
								if(isset($_SESSION['cart'])){
									$exist_cart = array();

									foreach($_SESSION['cart'] as $row){
										array_push($exist_cart, $row['productid']);
									}
									if(in_array($product['prodid'], $exist_cart)){ ?>
										<a class="btn btn-success btn-lg btn-flat" style="color: #fff" href="cart_view.php">
										<i class="fa fa-bag"></i> Buy now</a>
									<?php
									}else{
										?>
										<form class="form-inline" id="productForm">
											<div class="form-group">
												<input type="hidden" name="quantity" id="quantity" value="1">
												<input type="hidden" name="id" value="<?php echo $product['prodid']; ?>">
												<button type="submit" class="btn btn-primary btn-lg btn-flat add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
											</div>
										</form>
										<?php 
									}
								}else{
									?>
									<form class="form-inline" id="productForm">
										<div class="form-group">
											<input type="hidden" name="quantity" id="quantity" value="1">
											<input type="hidden" name="id" value="<?php echo $product['prodid']; ?>">
											<button type="submit" class="btn btn-primary btn-lg btn-flat add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</form>
									<?php 
								}
								
							}
							
							?>
							
		            	</div>
		            	<div class="col-sm-6">
		            		<h1 class="page-header"><?php echo $product['prodname']; ?></h1>
		            		<h3><b>&#2547; <?php echo number_format($product['price'], 2); ?></b></h3>
		            		<p><b>Category:</b> <a href="category.php?category=<?php echo $product['cat_slug']; ?>"><?php echo $product['catname']; ?></a></p>
		            		<p><b>Description:</b></p>
		            		<p><?php echo $product['description']; ?></p>
		            	</div>
		            </div>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>