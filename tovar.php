<?php 
include 'header.php'; 
$product_id = '';
if (!isset($_GET['product-id']) || $_GET['product-id'] == '') {
	die();
}
else{
	$product_id = $_GET['product-id'];
	$query = sequery("SELECT * FROM catalog WHERE id = $product_id AND status != 0 LIMIT 1");
	if (empty($query)) {
		die();
	}

}
$allmaxid = sequery("SELECT MAX(id) FROM catalog WHERE status != 0");
$allmaxid = $allmaxid['MAX(id)'];
$volume = $query['volume'];
$ip = $_SERVER['REMOTE_ADDR'];
$action = 0;
$zahod = query("INSERT INTO actions (action, product_id, ip) VALUES (:action, :product_id, :ip)", compact('action', 'product_id', 'ip'));


?>
<!--
<h3>Карточка товара</h3>
<div class="greyline1"></div>
-->
<div class="wrap5">
	<div class="tovar-page">
		<div class="row">
			<div class="col-md-6">
				<div class="iconss">
					<?php if ($query['status'] == 2) { ?>
					<span class="rasprodano">Распродано</span>
					<?php } ?>
					<?php if ($query['novinka'] == '1') { ?>
					<span class="novinka">Новинка</span>
					<?php } ?>
				</div>
				<img src="catalog/<?php echo $query['img_url']; ?>" alt="">
			</div>
			<div class="col-md-6">
				<div class="text-group">
					<h2>REFAN <strong><?php echo $query['refan']; ?></strong></h2>	
				</div>
				<div class="text-group">
					<p>Пол</p>
					<h5><?php if($query['gender']=='0'){echo "Женский";}else{echo "Мужской";} ?></h5>
				</div>
				<div class="text-group">
					<p>Бренд</p>
					<h5><a href="https://parfumanalog.ru/tovar.php?refan=<?php echo $query['refan']; ?>" target="_blank">REFAN</a></h5>
				</div>	
				<?php if($volume != ''){ ?>
				<div class="text-group">
					<p>Объём</p>
					<h5><?php echo $volume; ?>ML</h5>
				</div>
				<?php } ?>
				<div class="text-group">
					<p>Цена</p>
					<h4 style="font-weight: bold;"><?php echo $query['price']; ?> €</h4>
				</div>
				<div class="text-group">
					<input type="hidden" class="hidden-id" value="<?php echo $product_id; ?>">
					<input type="hidden" class="hidden-price" value="<?php echo $query['price']; ?>">
					<button class="add-productt">Добавить в корзину</button>
					<a class="buy-oneclickk">Купить в 1 клик</a>
				</div>								
			</div>
		</div>
		<?php if($query['aromagroup'] != ''){ ?>
		<div class="row mt-3">
			<div class="col-md-6">
				<img src="img/piramida.png" style="border-left: none;" alt="">
			</div>
			<div class="col-md-6">
				<div class="text-group">
					<p>Группа аромата</p>
					<h5><?php echo $query['aromagroup']; ?></h5>
				</div>
				<div class="text-group">
					<p>Год выпуска</p>
					<h5><?php echo $query['year']; ?></h5>
				</div>
				<div class="text-group">
					<p>Верхние ноты</p>
					<h5><?php echo $query['topnotes']; ?></h5>
				</div>
				<div class="text-group">
					<p>Ноты сердца</p>
					<h5><?php echo $query['middlenotes']; ?></h5>
				</div>
				<div class="text-group">
					<p>Базовые ноты</p>
					<h5><?php echo $query['bottomnotes']; ?></h5>
				</div>
			</div>
			
		</div>
		<?php } ?>
		<div class="row mt-3">
			<div class="col-md-12">
				<p class="descr"><?php echo $query['descr']; ?></p>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>