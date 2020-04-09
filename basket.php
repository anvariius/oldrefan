<?php 
include 'header.php';
$ids = '';
$basket_count = count($_SESSION['basket']);
if ($basket_count > 0) {
	foreach ($_SESSION['basket'] as $v) {
		$ids.= $v.', ';
	}
	$ids = substr($ids,0,-2);

	if ($basket_count > 1) {
		$query = sequery("SELECT * FROM catalog WHERE id IN (".$ids.") AND status = 1");
	}
	elseif ($basket_count == 1) {
		$query = sequery("SELECT * FROM catalog WHERE id=".$ids." AND status = 1");
		$query = array($query);
	}
}
else{
	$query = false;
}
$tovar = sequery("SELECT * FROM catalog WHERE id = 58 AND status = 1 AND intensive = 2 LIMIT 1");

//echo $ids;
//print_r($query);
?>
<h3>Корзина</h3>
<div class="greyline1"></div>
<div class="wrap5">
	<div class="basket">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered basket-table">
					<thead>
						<tr>
							<td>Изображение</td>
							<td>Название продукта</td>
							<td>Количество</td>
							<td class="full">цена за 1 шт</td>
							<td>ВСЕГО</td>
						</tr>
					</thead>
					<tbody>
						<?php 
						if ($query != false) { foreach ($query as $v) {
							if ($v['intensive'] == 4) {
							 	$v['fullname'] = $v['name']." ".$v['serie'];
							}else{
								$v['fullname'] = 'refan '.$v['refan']." ".getGender($v['gender'])." ".$v['volume']."ML";
							}
							
						?>
						<tr product_id="<?php echo $v['id']; ?>">
							<td><div class="img-block" style="background-image: url(catalog/<?php echo $v['img_url']; ?>);"></div></td>
							<td><?php echo $v['fullname'] ?></td>
							<td>
								<input type="number" class="numoftovar" min="1" max="20" value="1">
								<img src="img/refresh.png" class="refresh-product" alt="">
								<img src="img/delete.png" class="delete-product" alt="">
							</td>
							<td class="full">€<span class="current-price"><?php echo $v['price']; ?></span></td>
							<td>€<span class="total-price"><?php echo $v['price']; ?></span></td>
						</tr>
						<?php } }else{ ?>
						<tr><td colspan="5">Корзина пуста</td></tr>
						<?php } ?>	
					</tbody>
				</table>
			</div>
		</div>
		<!--
		<div class="row kupon">
			<div class="col-md-2">
				<span>введите купон</span>
			</div>
			<div class="col-md-7">
				<input type="text">
			</div>
			<div class="col-md-3">
				<button>применить</button>
			</div>
		</div>
		-->
		<div class="row">
			<div class="col-md-5 sposob-dostavki">
				<div class="citycheck form-group mt-3">
	      			<label>Выберите страну</label>
	      			<select>
	      				<option value="LV">Латвия</option>
	      				<option value="EE">Эстония</option>
	      				<option value="LT">Литва</option>
	      			</select>
	      		</div>
				<span>Способ доставки</span>
				<div class="form-check">
	        		<input class="form-check-input kuriyer" type="checkbox" id="gridCheck1">
	        		<label class="form-check-label" for="gridCheck1">
	          			Курьерская доставка - <b class="summa-dostavki">10</b> € 
	        		</label>
	      		</div>
	      		<div class="form-check">
	        		<input class="form-check-input freeship" checked="" type="checkbox" id="gridCheck1">
	        		<label class="form-check-label" for="gridCheck1">Пакомат Omniva - <b class="pakomat">3 €</b><img src="img/omniva-mini.png" alt="" class="mini-icon"></label>
	      		</div>
	      		
	      		<div class="form-group mt-3 pakomatto" style="display: none;">
		  			<label for="">Выберите удобный почтомат</label>
		  			<div id="omniva_container1"></div>
			  	</div>
			  	<div class="form-group mt-3 adrr">
		  			<label for="">Введите ваш адрес</label>
		  			<input class="adrs" id="adrs" type="text">
			  	</div>
	      		
			</div>
			<div class="col-md-4 offset-md-3">
				<table class="table table-bordered itogo-table">
					<tr>
						<td>СУММА</td>
						<td>€<span class="itogo-current" onload="getItogo();"></span></td>
					</tr>
					<tr>
						<td>к оплате</td>
						<td>€<span class="itogo-total" onload="getItogo();"></span></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row action-buttons">
			<div class="col-md-3">
				<button class="greyback btn" onclick="toPage('catalog.php');">продолжить покупки</button>
			</div>
			<div class="offset-md-6 col-md-3">
				<button <?php if ($query == false) {?> disabled <?php } ?> class="btn oform-pokupka">оформить покупку</button>
			</div>
		</div>
		<div class="row podarki">
			<h5>Подарочная упаковка для парфюма</h5>
			<a class="col-md-4 offset-md-4 product-block product-card" product_id="<?php echo $tovar['id']; ?>">
				<div class="product-img" style="background-image: url(catalog/<?php echo $tovar['img_url']; ?>);">
					<div class="top-block">
						<img src="img/intensive.png" class="intensive" alt="" data-toggle="tooltip" data-placement="bottom" data-original-title="Парфюмерная вода. Очень высокая стойкость аромата. Приятный шлейф. Более высокая концетрация ароматических масел в отличии от EDT">
						<?php if ($tovar['status'] == 2) { ?>
							<span class="rasprodano">Распродано</span>
						<?php } ?>
					</div>
					<div class="bottom-block">
						<?php if ($tovar['novinka'] == 1) { ?>
						<span class="novinka">Новинка</span>
						<?php } ?>
					</div>
				</div>
				<h4 class="product-name">REFAN <?php echo $tovar['refan']; ?></h4>
				<p class="product-descr"><?php echo getBrand($tovar['brand']); ?></p>
				<p class="product-price">€<?php echo $tovar['price']; ?></p>
				<button class="add-product" onclick="toPage('basket.php');">ДОБАВИТЬ В КОРЗИНУ</button>
			</a>	
		</div>
	</div>	
</div>
<script>
	var wd1 = new OmnivaWidget({

	    compact_mode: true,

	    show_offices: false,

	    custom_html: false,

	    id: 1,

	    selection_value: '',

	    country_id: $('.citycheck select').val(),
	});

</script>
<?php include 'footer.php'; ?>