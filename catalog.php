<?php 
	
	include 'header.php';
	if (isset($_GET['category'])) {
		

		$category = $_GET['category'];
		switch ($_GET['category']) {
			case 'man':
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 0 AND gender in (1,2)");
				break;
			case 'woman':
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 0 AND gender in (0,2)");				
				break;
			case 'brands':
				if (isset($_GET['brand-id'])) {
					$brand_id = $_GET['brand-id'];
					$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 0 AND brand = '$brand_id'");
					$category = 'brand-id';
					//print_r($query);
				}
				break;
			case 'probniki':
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 1");
				$category = 'probniki';	
				break;
			case 'accs':
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 2");
				$category = 'accs';
				break;	
			case 'nabor':
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 3");
				if (isset($_GET['gender'])) {
					$gender = $_GET['gender'];
					$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 3 AND gender = '$gender'");
				}
				$category = 'nabor';
				break;	
			default:
				$gender = 1;
				$category = 'man';
				$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 0 AND gender = 1");
				break;
		}
	}
	else{
		$gender = 1;
		$category = 'man';
		$query = sequery("SELECT * FROM catalog WHERE status != 0 AND intensive = 0 AND gender = 1");
				
	}

	$mans_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 0 AND gender in (1,2)");
	$womans_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 0 AND gender in (0,2)");
	$probniki_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 1");
	$accs_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 2");
	$nabor_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 3");
	$nabor0_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 3 AND gender = 0");
	$nabor1_count = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND intensive = 3 AND gender = 1");
	$brands = sequery("SELECT * FROM brands WHERE status != 0");
	$brands_count = sequery("SELECT COUNT(1) FROM brands WHERE status != 0");

	$allmaxid = sequery("SELECT MAX(id) FROM catalog WHERE status != 0");
	$allmaxid = $allmaxid['MAX(id)'];
	

	if (isset($query)) {
		if (count($query) == 0) {
			$query = false;
		}
		elseif (!isset($query[0]['id'])) {
			$query = array('1' => $query);
		}
		else{
			for ($j = 0; $j < count($query) - 1; $j++){

			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			        $num1 = $query[$i]['refan'];
			        if ($num1[0] == '0') {
			        	$num1 = substr($num1,1);
			        }
			        $num2 = $query[$i+1]['refan'];
			        if ($num2[0] == '0') {
			        	$num2 = substr($num2,1);
			        }
			        if ($num1 > $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			    
			}
		}
	}
	//print_r($query);
	//echo count($query)-10;
	//echo $_SERVER["REQUEST_URI"];
	
?>
<div class="left-menu">
	<table class="table table-bordered">
		<tr>
			<td><h2>КАТЕГОРИИ</h2></td>
		</tr>
		<tr>
			<td>
				<a href="#" class="razdel <?php if($category=='brand-id' || $category=='brands'){echo 'active';} ?>" isopened="false">бренды (<span><?php echo $brands_count['COUNT(1)']; ?></span>)<i class="fa fa-plus" aria-hidden="true"></i></a>
				<ul style="display: none;">
					<?php foreach ($brands as $v) {
						$brand_id = $v['id'];
						$que = sequery("SELECT COUNT(1) FROM catalog WHERE status != 0 AND brand = '$brand_id'");
					?>
					<li><a href="catalog.php?category=brands&brand-id=<?php echo $v['id']; ?>" class="podrazdel withhref"><?php echo $v['name']; ?> (<span><?php echo $que['COUNT(1)']; ?></span>)</a></li>
					<?php } ?>
				</ul>		
			</td>
		</tr>
		<tr>
			<td>
				<a href="catalog.php?category=woman" class="razdel withhref <?php if($category=='woman'){echo 'active';} ?>">ЖЕНСКИЕ (<span><?php echo $womans_count['COUNT(1)']; ?></span>)</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="catalog.php?category=man" class="razdel withhref <?php if($category=='man'){echo 'active';} ?>">МУЖСКИЕ (<span><?php echo $mans_count['COUNT(1)']; ?></span>)</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="catalog.php?category=probniki" class="razdel withhref <?php if($category=='probniki'){echo 'active';} ?>">ПРОБНИКИ (<span><?php echo $probniki_count['COUNT(1)']; ?></span>)</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href="catalog.php?category=accs" class="razdel withhref <?php if($category=='accs'){echo 'active';} ?>">Аксессуары (<span><?php echo $accs_count['COUNT(1)']; ?></span>)</a>
			</td>
		</tr>
		<tr>
			<td>

				<a href="#" class="razdel <?php if($category=='nabor'){echo 'active';} ?>" isopened="false">парфюмерные наборы (<span><?php echo $nabor_count['COUNT(1)']; ?></span>)<i class="fa fa-plus" aria-hidden="true"></i></a>
				<ul style="display: none;">
					<li><a href="catalog.php?category=nabor" class="podrazdel withhref">Все(<span><?php echo $nabor_count['COUNT(1)']; ?></span>)</a></li>
					<li><a href="catalog.php?category=nabor&gender=1" class="podrazdel withhref">Мужские(<span><?php echo $nabor1_count['COUNT(1)']; ?></span>)</a></li>
					<li><a href="catalog.php?category=nabor&gender=0" class="podrazdel withhref">Женские(<span><?php echo $nabor0_count['COUNT(1)']; ?></span>)</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td style="border-bottom: none;" class="full">
				<div style="min-height: 400px;"></div>
			</td>
		</tr>
	</table>
</div>
<?php if ($category == 'brands') { ?>
<div class="right-content">
	<div class="brands row">
		<?php 
			$a = 0; 
			foreach ($brands as $v) { 
		?>
		<div class="brand-block col-md-3" style="margin-top: 20px;" brand-id="<?php echo $v['id']; ?>">
			<div class="brand-img" style="background-image: url(brands/<?php echo $v['img_url']; ?>);"></div>
			<button><?php echo $v['name']; ?></button>
		</div>
		<?php } ?>
	</div>
</div>
<?php }else{ ?>	
<div class="right-content products">
	<div class="row products-block">
		<?php if ($query == false) {
			echo "Ничего не найдено";
		}else{ ?>
		<div class="col-md-4 offset-md-8">
			<a href="#" class="assort-link" target="blank">Ассортимент <img src="img/tab.png" alt=""></a>
		</div>	
		<?php foreach ($query as $v) { ?>
		<a class="col-md-4 product-block product-card" product_id="<?php echo $v['id']; ?>" refan="<?php echo $v['refan']; ?>" category="<?php echo $v['gender']; ?>">
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
		</a>	
	<?php } } ?>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	if ($('.right-content').height() > $(".catalog").height()) {
		var hght = $('.right-content').height();
		$(".left-menu").css('height',hght);
		$(".catalog").css('height',hght+60);
	}
	var category = "<?php echo $category; ?>";
	console.log(category);
	if (category == 'woman') {
		switch($('html').attr('lang')){
			case 'en':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/1XoiAD7Aellb1ZWultb1wK4fG1xXTu6gCmScLWm60gvA/edit?usp=sharing');
				break;
			case 'lv':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/1ConIFIDl5QWWUZaDGJtud-oIs-0sKC0NbP2vMEm5DfY/edit?usp=sharing');
				break;	
			case 'ru':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/1VpqIw-PRpYi7jSUnTpDAVHay9ig70W9TzkGwHK3ejyU/edit?usp=sharing');
				break;	
			default:
				$('.assort-link').hide();
				break;	
		}
	}
	else if(category == 'man'){
		switch($('html').attr('lang')){
			case 'en':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/164BAUp9g_Y70xsKqupXnzPulqYYukYFBdWgjCLeeRCw/edit?usp=sharing');
				break;
			case 'lv':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/1pcpddUCDrvM5XJjkMezETPw1XYOKXXQkEbQCApvTBhY/edit?usp=sharing');
				break;	
			case 'ru':
				$('.assort-link').attr('href','https://docs.google.com/spreadsheets/d/1Y0XIi6SJ6IC7L0fBN_Tg1wMrbPGcwVefeZzTo7b0Qy4/edit?usp=sharing');
				break;	
			default:
				$('.assort-link').hide();
				break;	
		}
	}	
	else{
		$('.assort-link').hide();
	}
</script>
<?php include 'footer.php'; ?>