<?php 
include '../bt/pdo.php';
include 'header.php';
session_start();
if (!isset($_SESSION['sort'])) {
	$_SESSION['sort'] = 'old';
	$_SESSION['sort_text'] = 'Сначала старые';
}
if (!isset($_COOKIE['auth']) || $_COOKIE['auth'] != 's6cWZ6xUyG') {
	header("Location: index.php");
}
if (isset($_GET['category'])) {
	$category = $_GET['category'];	
}
else{
	$category = 'all';
}
switch ($category) {
	case 'all':
		$query = sequery("SELECT * FROM catalog WHERE status = 1");
		$qtext = 'Все товары';
		break;
	case 'mans':
		$query = sequery("SELECT * FROM catalog WHERE status = 1 AND intensive = 0 AND gender = 1");
		$qtext = 'Мужские';
		break;
	case 'accs':
		$query = sequery("SELECT * FROM catalog WHERE status = 1 AND intensive = 2");
		$qtext = 'Аксессуары';				
		break;
	case 'nabor':
		$query = sequery("SELECT * FROM catalog WHERE status = 1 AND intensive = 3");
		$qtext = 'Наборы';				
		break;
	case 'womans':
		$query = sequery("SELECT * FROM catalog WHERE status = 1 AND intensive = 0 AND gender = 0");
		$qtext = 'Женские';				
		break;		
	case 'probniki':
		$query = sequery("SELECT * FROM catalog WHERE status = 1 AND intensive = 1");
		$qtext = 'Пробники';
		break;	
	case 'soldout':
		$query = sequery("SELECT * FROM catalog WHERE status = 2");
		$qtext = 'Распродано';
		break;	
	case 'removed':
		$query = sequery("SELECT * FROM catalog WHERE status = 0");
		$qtext = 'Недавно удаленные';
		break;	
	case 'search':
		if (isset($_GET['query'])) {
			$zapros = $_GET['query'];
		}else{
			header('Location: main.php');
		}	
		$query = sequery("SELECT * FROM catalog WHERE name LIKE '%$zapros%' OR brand LIKE '%$zapros%'");
		$qtext = 'Поиск: '.$zapros;
		break;
	case 'brand-id':
		$brand_id = $_GET['brand-id'];
		$qtext = 'Бренд: '.getBrand($brand_id);
		$query = sequery("SELECT * FROM catalog WHERE status = 1  AND accs = 0 AND brand =".$brand_id);
		break;	
	case 'brands':
		$qtext = 'Бренды';
		$query = array();
		break;			
	default:
		header('Location: main.php');
		break;
}
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
else{
	switch ($_SESSION['sort']) {
		case 'new':
			$query = array_reverse($query);
			break;
		case 'refanup':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			        $query[$i]['name'] = trim($query[$i]['name']);
			        $query[$i+1]['name'] = trim($query[$i+1]['name']);
			        $num1 = substr($query[$i]['name'],-4,3);
			        if ($num1[0] == '0') {
			        	$num1 = substr($num1,1);
			        }
			        $num2 = substr($query[$i+1]['name'],-4,3);
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
			break;
		case 'refandown':
			for ($j = 0; $j < count($query) - 1; $j++){
			    for ($i = 0; $i < count($query) - $j - 1; $i++){
			        // если текущий элемент больше следующего
			        $query[$i]['name'] = trim($query[$i]['name']);
			        $query[$i+1]['name'] = trim($query[$i+1]['name']);
			        $num1 = substr($query[$i]['name'],-4,3);
			        if ($num1[0] == '0') {
			        	$num1 = substr($num1,1);
			        }
			        $num2 = substr($query[$i+1]['name'],-4,3);
			        if ($num2[0] == '0') {
			        	$num2 = substr($num2,1);
			        }
			        if ($num1 < $num2){
			            // меняем местами элементы
			            $tmp_var = $query[$i + 1];
			            $query[$i + 1] = $query[$i];
			            $query[$i] = $tmp_var;
			        }
			    }
			}
			break;
		default:
			# code...
			break;
	}
}


$brands = sequery("SELECT * FROM brands WHERE status = 1");
?>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			      	<a class="nav-link <?php if($category == 'all'){echo 'active';} ?>" href="main.php">все товары</a>
			      	<a class="nav-link <?php if($category == 'womans'){echo 'active';} ?>" href="?category=womans">женские</a>
			      	<a class="nav-link <?php if($category == 'mans'){echo 'active';} ?>" href="main.php?category=mans">мужские</a>
			      	<a class="nav-link <?php if($category == 'accs'){echo 'active';} ?>" href="main.php?category=accs">аксессуары</a>
			      	<a class="nav-link <?php if($category == 'nabor'){echo 'active';} ?>" href="main.php?category=nabor">парфюмерные наборы</a>
			      	<a class="nav-link <?php if($category == 'probniki'){echo 'active';} ?>" href="?category=probniki">пробники</a>
			      	<a class="nav-link <?php if($category == 'brands' || $category == 'brand-id'){echo 'active';} ?>" href="main.php?category=brands">бренды</a>
			      	<a class="nav-link <?php if($category == 'removed'){echo 'active';} ?>" href="main.php?category=removed">Удаленные товары</a>
			      	<a class="nav-link <?php if($category == 'soldout'){echo 'active';} ?>" href="?category=soldout">Распродано</a>
			      	<button class="btn btn-success add-tovar mt-5" onclick="openModal('add_tovar');">Добавить товар</button>
			      	<button class="btn btn-info add-brand mt-1">Добавить бренд</button>
			    </div>
			</div>
			<div class="col-md-9">
				<?php if($category == 'brands'){ ?>
					<h3 class="text-center mb-5"><?php echo $qtext; ?></h3> 
					<div class="row">
					<?php foreach ($brands as $v){ ?>
					<div class="col-md-4">	
						<div class="card mb-4" brand-id="<?php echo $v['id']; ?>">
							<div class="img-top" style="background-size: 70%;background-image: url(../brands/<?php echo $v['img_url']; ?>)"></div>
							<div class="card-body">
								<h5 class="card-title"><?php echo $v['name']; ?></h5>
								<a href="#" onclick="toPage('main.php?category=brand-id&brand-id=<?php echo $v["id"]; ?>')" class="btn btn-primary btn-block">Посмотреть товары</a>
								<a href="#" class="btn btn-danger btn-block remove-brand">Удалить</a>
							</div>
						</div>
					</div>	
					<?php } ?>
					</div>	
				<?php }else{ if($query){ ?>
				<div class="row">
					<div class="col-md-9">
						<h3 class="text-left mb-5"><?php echo $qtext; ?></h3>
					</div>
					<div class="col-md-3">
						<div class="btn-group set-sort">
						  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['sort_text']; ?></button>
						  	<div class="dropdown-menu">
							    <a class="dropdown-item" href="new">Сначала новые</a>
							    <a class="dropdown-item" href="old">Сначала старые</a>
							    <a class="dropdown-item" href="refanup">Refan по возрастанию</a>
							    <a class="dropdown-item" href="refandown">Refan по убыванию</a>				    
						  	</div>
						</div>
					</div>
				</div> 
				<div class="row">
				<?php foreach ($query as $v){ ?>
				<div class="col-md-4">	
					<div class="card mb-4" product-id="<?php echo $v['id']; ?>">
					  	<div class="img-top" style="background-image: url(../catalog/<?php echo $v['img_url']; ?>)"></div>
					  	<div class="card-body">
					  		<input type="hidden" class="product-brand" value='<?php echo $v['brand']; ?>'>
					  		<input type="hidden" class="product-name" value='<?php echo $v['name']; ?>'>
					  		<input type="hidden" class="product-refan" value='<?php echo $v['refan']; ?>'>
					  		<input type="hidden" class="product-volume" value='<?php echo $v['volume']; ?>'>
					  		<input type="hidden" class="product-descr" value='<?php echo  str_replace("<br />", "", $v['descr']); ?>'>
					  		<input type="hidden" class="product-price" value='<?php echo $v['price']; ?>'>
					  		<input type="hidden" class="product-gender" value='<?php echo $v['gender']; ?>'>
					  		<input type="hidden" class="product-intensive" value='<?php echo $v['intensive']; ?>'>
					  		<input type="hidden" class="product-aromagroup" value='<?php echo $v['aromagroup']; ?>'>
					  		<input type="hidden" class="product-year" value='<?php echo $v['year']; ?>'>
					  		<input type="hidden" class="product-topnotes" value='<?php echo $v['topnotes']; ?>'>
					  		<input type="hidden" class="product-middlenotes" value='<?php echo $v['middlenotes']; ?>'>
					  		<input type="hidden" class="product-bottomnotes" value='<?php echo $v['bottomnotes']; ?>'>
					  		<input type="hidden" class="product-novinkin" value='<?php echo $v['novinka']; ?>'>
					    	<h5 class="card-title">Refan <?php echo $v['refan']; ?></h5>
					    	<p class="card-text"><?php echo getBrand($v['brand']); ?></p>
					    	<span class="badge badge-primary" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo  str_replace("<br />", "", $v['descr']); ?>" style="cursor: pointer;">Описание</span>
					    	<p class="card-text font-weight-bold"><?php echo $v['price']; ?> €</p>
					    	<?php if($category != 'removed'){ ?>
					    	<a href="#" class="btn btn-primary change-button">Изменить</a>
					    	<a href="#" class="btn btn-danger remove-button">Удалить</a>
					    	<?php }else{ ?>
				    		<a href="#" class="btn btn-primary btn-block restore-button">Восстановить</a>
				    		<?php } ?>
					  	</div>
					</div>
				</div>
				<?php } }else{ ?>
				<h3 class="text-center">Ничего не найдено</h3>
				<?php } } ?>	
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="modal tovar-modal" tabindex="-1" role="dialog">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title">Добавить товар</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        			</button>
      			</div>
      			<div class="modal-body">
        			<form action="engine2.php" method="post" enctype="multipart/form-data">
        				<input type="hidden" name="action" value="add_tovar">
        				<input type="hidden" name="token" value="<?php echo $token2; ?>">
        				<input type="hidden" name="id" value="" class="product-id">
        				<div class="form-group">
        					<label class="font-weight-bold">Тип товара</label>
        					<select name="intensive" class="tovar-intensive form-control">
        						<option value="0">Парфюм</option>
        						<option value="1">Пробник</option>
        						<option value="2">Аксессуар</option>
        						<option value="3">Парфюмерный набор</option>
        					</select>
        				</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Название товара</label>
    						<input type="text" name="name" required="" class="form-control tovar-name" placeholder="Введите название">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Refan</label>
    						<input type="text" name="refan" required="" class="form-control tovar-refan" placeholder="Введите refan">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Обьем</label>
    						<div class="input-group">
    							<input type="number" name="volume" class="form-control tovar-volume" placeholder="Введите обьем">
	    						<div class="input-group-append">
						          	<div class="input-group-text font-weight-bold">ML</div>
						        </div>
    						</div>
  						</div>
  						<div class="form-group brand-block">
  							<label class="font-weight-bold">Название Бренда</label>
    						<select class="form-control tovar-brand" name="brand">		
    							<?php foreach ($brands as $v) {?>
    							<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>	
    							<?php } ?>
    						</select>
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Описание товара</label>
    						<textarea name="descr" class="form-control tovar-descr" placeholder="Введите описание" cols="30" rows="10"></textarea>
  						</div>
  					<div class="aroma-params">	
  						<div class="form-group">
    						<label class="font-weight-bold">Группа аромата</label>
    						<input type="text" name="aromagroup" class="form-control tovar-aromagroup" placeholder="Введите группу аромата">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Год выпуска</label>
    						<input type="text" name="year" class="form-control tovar-year" placeholder="Введите год выпуска">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Верхние ноты</label>
    						<input type="text" name="topnotes" class="form-control tovar-topnotes" placeholder="Введите верхние ноты">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Ноты сердца</label>
    						<input type="text" name="middlenotes" class="form-control tovar-middlenotes" placeholder="Введите ноты сердца">
  						</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Базовые ноты</label>
    						<input type="text" name="bottomnotes" class="form-control tovar-bottomnotes" placeholder="Введите базовые ноты">
  						</div>
					</div>
  						<div class="form-group">
    						<label class="font-weight-bold">Цена товара</label>
    						<div class="input-group">
    							<input type="number" name="price" required="" class="form-control tovar-price" placeholder="Введите цену">
	    						<div class="input-group-append">
						          	<div class="input-group-text font-weight-bold">€</div>
						        </div>
    						</div>
  						</div>
  						<div class="form-check">
  							<input type="radio" class="form-check-input tovar-gender" name="gender" value="1">
  							<label class="form-check-label">
    							Мужской
  							</label>
  						<div class="form-check">
  						</div>	
  							<input type="radio" class="form-check-input tovar-gender" name="gender" value="0" checked>
  							<label class="form-check-label">
    							Женский
  							</label>
  						</div>
  						<div class="form-group mt-1">
    						<label class="font-weight-bold">Изображение</label>
    						<input type="file" name="img" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file  tovar-img">
  						</div>
  						<div class="form-group mt-1">
  							<div class="form-check soldout">
	  							<input type="checkbox" name="soldout" class="form-check-input">
	    						<label class="font-weight-bold form-check-label">Распродано</label>
	  						</div>
  						</div>
  						<div class="form-group mt-1">
  							<div class="form-check novinkin">
	  							<input type="checkbox" name="novinka" class="form-check-input">
	    						<label class="font-weight-bold form-check-label">Новинка</label>
	  						</div>
  						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Сохранить</button>
							<button class="btn btn-danger" data-dismiss="modal">Отменить</button>
						</div>
					</form>
      			</div>
    		</div>
  		</div>
	</div>

	<div class="modal brand-modal" tabindex="-1" role="dialog">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title">Добавить бренд</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        			</button>
      			</div>
      			<div class="modal-body">
        			<form action="engine2.php" method="post" enctype="multipart/form-data">
        				<input type="hidden" name="action" value="add_brand">
        				<input type="hidden" name="token" value="<?php echo $token2; ?>">
  						<div class="form-group">
    						<label class="font-weight-bold">Название бренда</label>
    						<input type="text" name="name" required="" class="form-control brand-name" placeholder="Введите название">
  						</div>
  						<div class="form-group mt-1">
    						<label class="font-weight-bold">Изображение</label>
    						<input type="file" name="img" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file  brand-img">
  						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Сохранить</button>
							<button class="btn btn-danger" data-dismiss="modal">Отменить</button>
						</div>
					</form>
      			</div>
    		</div>
  		</div>
  	</div>
<script>

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});

	function openModal(action,element) {
		if (action == 'add_tovar') {
			$('.tovar-modal .modal-title').text('Добавить товар');
			$('.tovar-modal .tovar-name').val('');
			$('.tovar-modal .tovar-refan').val('');
			$('.tovar-modal .tovar-volume').val('');
			$('.tovar-modal .tovar-descr').val('');
			$('.tovar-modal .tovar-aromagroup').val('');
			$('.tovar-modal .tovar-year').val('');
			$('.tovar-modal .tovar-topnotes').val('');
			$('.tovar-modal .tovar-middlenotes').val('');
			$('.tovar-modal .tovar-bottomnotes').val('');
			$('.tovar-modal input[name="action"]').val('add_tovar');
			$('.tovar-modal input[name="token"]').val('<?php echo $token2; ?>');
			$('.tovar-modal .tovar-img').attr('required','true');
			$('.tovar-modal .tovar-img').closest('.form-group').find('label').text("Изображение");
			$(".tovar-modal .tovar-brand option[value='1']").attr('selected','selected');
			$('.tovar-modal .tovar-price').val('');
			$('.tovar-modal .tovar-gender[value="0"]').attr('checked',true);
			$(".tovar-intensive [value='0']").attr('selected', 'selected');
			$('.product-id').val('');
			$('.soldout').hide();
			$('.novinkin input').attr('checked','true');
		}
		else if(action == 'change_tovar'){
			var name = element.find('.product-name').val(),
			refan = element.find('.product-refan').val(),
			volume = element.find('.product-volume').val(),
			descr = element.find('.product-descr').val(),
			brand = element.find('.product-brand').val(),
			gender = element.find('.product-gender').val(),
			intensive = element.find('.product-intensive').val(),
			price = element.find('.product-price').val(),
			aromagroup = element.find('.product-aromagroup').val(),
			year = element.find('.product-year').val(),
			topnotes = element.find('.product-topnotes').val(),
			middlenotes = element.find('.product-middlenotes').val(),
			bottomnotes = element.find('.product-bottomnotes').val(),
			novinkin = element.find('.product-novinkin').val();

			$('.tovar-modal .modal-title').text('Изменить товар');
			$('.tovar-modal input[name="action"]').val('change_tovar');
			$('.tovar-modal input[name="token"]').val('<?php echo $token2; ?>');
			$('.tovar-modal .tovar-name').val(name);
			$('.tovar-modal .tovar-refan').val(refan);
			$('.tovar-modal .tovar-volume').val(volume);
			$('.tovar-modal .tovar-descr').val(descr);
			$('.tovar-modal .tovar-aromagroup').val(aromagroup);
			$('.tovar-modal .tovar-year').val(year);
			$('.tovar-modal .tovar-topnotes').val(topnotes);
			$('.tovar-modal .tovar-middlenotes').val(middlenotes);
			$('.tovar-modal .tovar-bottomnotes').val(bottomnotes);
			$(".tovar-modal .tovar-brand option[value='"+brand+"']").attr('selected','selected');
			$('.tovar-modal .tovar-price').val(price);
			$('.tovar-modal .tovar-gender[value="'+gender+'"]').attr('checked',true);
			$('.product-id').val(element.attr('product-id'));
			$(".tovar-intensive [value='"+intensive+"']").attr('selected', 'selected');
			$('.tovar-modal .tovar-img').removeAttr('required');
			$('.tovar-modal .tovar-img').closest('.form-group').find('label').text("Изображение(не обязательно)");
			$('.soldout').show();

			<?php if ($category == 'soldout') { ?>
			$('.soldout input').attr('checked','true');
			<?php } ?>	
			
			if (novinkin == '1') {
				$('.novinkin input').attr('checked','true');
			}
			else{
				$('.novinkin input').removeAttr('checked');
			}
			
			

			console.log(name);


		}
		if ($(".tovar-intensive option:selected").val() == 0 || $(".tovar-intensive option:selected").val() == 1) {
			$('.aroma-params').show();
		}
		else{
			$('.aroma-params').hide();
			$('.aroma-params input').val('');
		}
		$('.tovar-modal').modal('show');
		
	}

	
	$('.tovar-intensive').change(function(event) {
		if ($(".tovar-intensive option:selected").val() == 0 || $(".tovar-intensive option:selected").val() == 1) {
			$('.aroma-params').show();
		}
		else{
			$('.aroma-params').hide();
		}
	});

	$('.card a').click(function(event) {
		event.preventDefault();
	});
	$('.remove-button').click(function () {
		var product_id = $(this).closest('.card').attr('product-id');
		$.post('engine2.php', {action: 'remove_tovar', token: '<?php echo $token2; ?>',product_id: product_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).closest('.card').parent('div').hide();
	});
	$('.restore-button').click(function () {
		var product_id = $(this).closest('.card').attr('product-id');
		$.post('engine2.php', {action: 'restore_tovar',token: '<?php echo $token2; ?>',product_id: product_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-secondary');
		$(this).addClass('disabled');
		$(this).text('Восстановлено');
	});
	
	$('.change-button').click(function(event) {
		openModal('change_tovar',$(this).closest('.card'));
	});

	$('.add-brand').click(function(event) {
		$('.brand-modal .brand-name').val('');
		$('.brand-modal .brand-img').val('');
		$('.brand-modal').modal('show');
	});
	$('.remove-brand').click(function () {
		var brand_id = $(this).closest('.card').attr('brand-id');
		$.post('engine2.php', {action: 'remove_brand',token: '<?php echo $token2; ?>',brand_id: brand_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).closest('.card').parent('div').hide();
	});

	$('.set-sort a').click(function(event) {
		event.preventDefault();
		var sort = $(this).attr('href'),
			sort_text = $(this).text();
		$.post('engine2.php', {action: 'set_sort',token: '<?php echo $token2; ?>',sort: sort,sort_text: sort_text}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		location.reload();
	});
	//$('.modal').modal('show');
</script>	
<?php include 'footer.php'; ?>