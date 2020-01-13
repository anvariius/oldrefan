<?php 
	include 'header.php';
	if (!isset($_GET['query']) || $_GET['query'] == '') {
		die();
	}
	else{
		$zapros = $_GET['query'];
		$query = sequery("SELECT * FROM catalog WHERE name LIKE '%$zapros%' OR brand LIKE '%$zapros%' OR refan LIKE '%$zapros%'");
	}
?>
<h3>ПОИСК - <?php echo $zapros; ?></h3>
<div class="greyline1"></div>
<div class="products">
	<div class="products-block">
		<div class="row">
		<?php if (count($query) == 0) { ?>
			<h5 style="text-align: center; margin: 0 auto;">Ничего не найдено</h5>
		<?php } else {
			if (!isset($query[0]['id'])) {
				$query = array('1' => $query);
		} ?>	
		<?php foreach ($query as $v) { ?>
			<div class="col-md-3 product-card" product_id="<?php echo $v['id']; ?>">
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
		<?php } } ?>	
		</div>
	</div>
</div>	
<?php include 'footer.php'; ?>