<?php 
include 'header.php';
$query1 = sequery("SELECT * FROM catalog WHERE status != 0 AND novinka = 1 ORDER BY id DESC LIMIT 4");
$query3 = sequery("SELECT * FROM catalog WHERE intensive = 1 AND status != 0 ORDER BY id DESC LIMIT 4");
$popular = sequery("SELECT product_id, COUNT(product_id) FROM actions WHERE action = 0 AND status != 0 GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 4");
$hits = sequery("SELECT product_id, COUNT(product_id) FROM actions WHERE action = 1 AND status != 0 GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 4");
$query2 = [];
$query4 = [];
foreach ($popular as $v) {
	$product_id = $v['product_id'];
	array_push($query4, sequery("SELECT * FROM catalog WHERE status != 0 AND id = :product_id", compact('product_id'))); 
}
foreach ($hits as $v) {
	$product_id = $v['product_id'];
	array_push($query2, sequery("SELECT * FROM catalog WHERE status != 0 AND id = :product_id", compact('product_id'))); 
}

$brands = sequery("SELECT * FROM brands WHERE status = 1");
$brands_count = sequery("SELECT COUNT(1) FROM brands WHERE status = 1");
$brands_count = $brands_count['COUNT(1)'];
?>

				<div class="banners">
					<div class="row">
						<div class="col-sm-6"><a href="catalog.php?categoty=man"><img src="img/bannerformen.png" alt=""></a></div>
						<div class="col-sm-6"><a href="catalog.php?category=woman"><img src="img/bannerforwomen.png" alt=""></a></div>
					</div>
				</div>
				<div class="nav">
					<li><a href="#" class="active" ta=".new">Новинки</a></li>
					<li><a href="#" ta=".hits">хиты продаж</a></li>
					<li><a href="#" ta=".probnic">пробники</a></li>
					<li><a href="#" ta=".popular">популярные</a></li>
				</div>
				<div class="products">
					<div class="products-block">
						<div class="row new">
						<?php foreach ($query1 as $v) { ?>
							<div class="col-md-3 col-sm-6 product-card" product_id="<?php echo $v['id']; ?>" refan="<?php echo $v['refan']; ?>" category="<?php echo $v['gender']; ?>">
								<div class="product-img" style="background-image: url(catalog/<?php echo $v['img_url']; ?>);">
									<div class="top-block">
										<img src="img/intensive.png" class="intensive" alt="" data-toggle="tooltip" data-placement="bottom" data-original-title="Парфюмерная вода. Очень высокая стойкость аромата. Приятный шлейф. Более высокая концетрация ароматических масел в отличии от EDT">
										<?php if ($v['status'] == 2) { ?>
											<span class="rasprodano">Распродано</span>
										<?php } ?>
									</div>
									<?php if($v['novinka'] == '1'){ ?>
									<div class="bottom-block">
										<span class="novinka">Новинка</span>
									</div>
									<?php } ?>
								</div>
								<h4 class="product-name">REFAN <span><?php echo $v['refan']; ?></span></h4>
								<h5 class="product-gender"><?php echo getGender($v['gender']); ?> <?php if($v['volume'] !='') echo $v['volume']."ML"; ?></h5>
								<p class="product-descr">www.parfumanalog.ru</p>
								<p class="product-price">€<?php echo $v['price']; ?></p>
								<button class="product-opisanie" data-toggle="tooltip" data-placement="top" data-original-title='<?php echo str_replace("<br />", "", $v['descr']); ?>'>Описание товара</button>
								<button class="add-product">ДОБАВИТЬ В КОРЗИНУ</button>
								<p class="buy-oneclick">купить в 1 клик</p>
							</div>
						<?php } ?>	
						</div>
						<div class="row hits" style="display: none;">
						<?php foreach ($query2 as $v) { ?>
							<div class="col-md-3 col-sm-6 product-card" product_id="<?php echo $v['id']; ?>" refan="<?php echo $v['refan']; ?>" category="<?php echo $v['gender']; ?>">
								<div class="product-img" style="background-image: url(catalog/<?php echo $v['img_url']; ?>);">
									<div class="top-block">
										<img src="img/intensive.png" class="intensive" alt="" data-toggle="tooltip" data-placement="bottom" data-original-title="Парфюмерная вода. Очень высокая стойкость аромата. Приятный шлейф. Более высокая концетрация ароматических масел в отличии от EDT">
										<?php if ($v['status'] == 2) { ?>
											<span class="rasprodano">Распродано</span>
										<?php } ?>
									</div>
									<?php if($v['novinka'] == '1'){ ?>
									<div class="bottom-block">
										<span class="novinka">Новинка</span>
									</div>
									<?php } ?>
								</div>
								<h4 class="product-name">REFAN <span><?php echo $v['refan']; ?></span></h4>
								<h5 class="product-gender"><?php echo getGender($v['gender']); ?> <?php if($v['volume'] !='') echo $v['volume']."ML"; ?></h5>
								<p class="product-descr">www.parfumanalog.ru</p>
								<p class="product-price">€<?php echo $v['price']; ?></p>
								<button class="product-opisanie" data-toggle="tooltip" data-placement="top" data-original-title='<?php echo str_replace("<br />", "", $v['descr']); ?>'>Описание товара</button>
								<button class="add-product">ДОБАВИТЬ В КОРЗИНУ</button>
								<p class="buy-oneclick">купить в 1 клик</p>
							</div>
						<?php } ?>	
						</div>
						<div class="row probnic" style="display: none;">
						<?php foreach ($query3 as $v) { ?>
							<div class="col-md-3 col-sm-6 product-card" product_id="<?php echo $v['id']; ?>" refan="<?php echo $v['refan']; ?>" category="<?php echo $v['gender']; ?>">
								<div class="product-img" style="background-image: url(catalog/<?php echo $v['img_url']; ?>);">
									<div class="top-block">
										<img src="img/intensive.png" class="intensive" alt="" data-toggle="tooltip" data-placement="bottom" data-original-title="Парфюмерная вода. Очень высокая стойкость аромата. Приятный шлейф. Более высокая концетрация ароматических масел в отличии от EDT">
										<?php if ($v['status'] == 2) { ?>
											<span class="rasprodano">Распродано</span>
										<?php } ?>
									</div>
									<?php if($v['novinka'] == '1'){ ?>
									<div class="bottom-block">
										<span class="novinka">Новинка</span>
									</div>
									<?php } ?>
								</div>
								<h4 class="product-name">REFAN <span><?php echo $v['refan']; ?></span></h4>
								<h5 class="product-gender"><?php echo getGender($v['gender']); ?> <?php if($v['volume'] !='') echo $v['volume']."ML"; ?></h5>
								<p class="product-descr">www.parfumanalog.ru</p>
								<p class="product-price">€<?php echo $v['price']; ?></p>
								<button class="product-opisanie" data-toggle="tooltip" data-placement="top" data-original-title='<?php echo str_replace("<br />", "", $v['descr']); ?>'>Описание товара</button>
								<button class="add-product">ДОБАВИТЬ В КОРЗИНУ</button>
								<p class="buy-oneclick">купить в 1 клик</p>
							</div>
						<?php } ?>	
						</div>
						<div class="row popular" style="display: none;">
						<?php foreach ($query4 as $v) { ?>
							<div class="col-md-3 col-sm-6 product-card" product_id="<?php echo $v['id']; ?>" refan="<?php echo $v['refan']; ?>" category="<?php echo $v['gender']; ?>">
								<div class="product-img" style="background-image: url(catalog/<?php echo $v['img_url']; ?>);">
									<div class="top-block">
										<img src="img/intensive.png" class="intensive" alt="" data-toggle="tooltip" data-placement="bottom" data-original-title="Парфюмерная вода. Очень высокая стойкость аромата. Приятный шлейф. Более высокая концетрация ароматических масел в отличии от EDT">
										<?php if ($v['status'] == 2) { ?>
											<span class="rasprodano">Распродано</span>
										<?php } ?>
									</div>
									<?php if($v['novinka'] == '1'){ ?>
									<div class="bottom-block">
										<span class="novinka">Новинка</span>
									</div>
									<?php } ?>
								</div>
								<h4 class="product-name">REFAN <span><?php echo $v['refan']; ?></span></h4>
								<h5 class="product-gender"><?php echo getGender($v['gender']); ?> <?php if($v['volume'] !='') echo $v['volume']."ML"; ?></h5>
								<p class="product-descr">www.parfumanalog.ru</p>
								<p class="product-price">€<?php echo $v['price']; ?></p>
								<button class="product-opisanie" data-toggle="tooltip" data-placement="top" data-original-title='<?php echo str_replace("<br />", "", $v['descr']); ?>'>Описание товара</button>
								<button class="add-product">ДОБАВИТЬ В КОРЗИНУ</button>
								<p class="buy-oneclick">купить в 1 клик</p>
							</div>
						<?php } ?>	
						</div>
					</div>
					<!--
					<div class="slider-buttons">
						<div class="slider-circle active"></div>
						<div class="slider-circle"></div>
					</div>
					-->
					<br>
					<br>
					<div class="brands row">
						<?php 
							$a = 0; 
							foreach ($brands as $v) { 
						?>
						<div class="brand-block col-md-2" brand-id="<?php echo $v['id']; ?>">
							<div class="brand-img" style="background-image: url(brands/<?php echo $v['img_url']; ?>);"></div>
							<button><?php echo $v['name']; ?></button>
						</div>
						<?php } ?>
					</div>		

					
<?php if (isset($_GET['zakaz']) && $_GET['zakaz'] == 'true') { ?>
<script>
	function openModal(element) {
		$('.sidebar').hide();
		$('.sidebar-opacity').removeClass('toggled');
		$('.modal-wrapper').css('visibility','visible');
		$('body').css('overflow-y','hidden');
		$(element).fadeIn('400');
	}
	var hash_email = '<?php echo  $_GET["email"]; ?>';
	var hash_phone = '<?php echo  $_GET["phone"]; ?>';
	openModal('.zakaz');
</script>	
<?php } ?>	
<script>
	$(document).on('click', '.catalog .nav a', function(event) {
		event.preventDefault();
		$('.catalog .nav a').removeClass('active');
		$(this).addClass('active');
		$('.products .row').hide();
		$('.products .brands').show();
		var ClASs = $(this).attr('ta');
		console.log($(this).attr('ta'));
		$(ClASs).show();
	});
	
</script>			
<?php include 'footer.php'; ?>