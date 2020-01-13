<?php 
include '../bt/pdo.php';
include 'header.php'; 

if (isset($_GET['category'])) {
	$category = $_GET['category'];	
}
else{
	$category = 'all';
}
switch ($category) {
	case 'all':
		$query = sequery("SELECT * FROM assort WHERE status = 1 ORDER BY cell");
		$qtext = 'Все товары';
		break;	
	case 'removed':
		$query = sequery("SELECT * FROM assort WHERE status = 0");
		$qtext = 'Недавно удаленные';
		break;			
	default:
		header('Location: assortiment.php');
		break;
}
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		      	<a class="nav-link <?php if($category == 'all'){echo 'active';} ?>" href="assortiment.php">все</a>
		      	<a class="nav-link <?php if($category == 'removed'){echo 'active';} ?>" href="assortiment.php?category=removed">Удаленные товары</a>
		      	<button class="btn btn-success add-tovar mt-5" onclick="openModal('add_tovar');">Добавить товар</button>
		    </div>
		</div>
		<div class="col-md-9">
			<h3 class="text-center mb-5">Ассортимент торговых автоматов</h3>
			<div class="row">
			<?php if($query){ foreach ($query as $v){ ?>
			<div class="col-md-4">	
				<div class="card mb-4" product-id="<?php echo $v['id']; ?>">
				  	<div class="img-top" style="background-image: url(../assort/<?php echo $v['img_url']; ?>)"></div>
				  	<div class="card-body">
				  		<input type="hidden" class="product-name" value='<?php echo $v['name']; ?>'>
				  		<input type="hidden" class="product-cell" value='<?php echo $v['cell']; ?>'>
				  		<input type="hidden" class="product-volume" value='<?php echo $v['volume']; ?>'>
				  		<input type="hidden" class="product-refan" value='<?php echo $v['refan']; ?>'>
				    	<h5 class="card-title">
				    		<?php echo $v['name']; ?><br>(REFAN <?php echo $v['refan']; ?>)
				    	</h5>
				    	<span class="badge badge-primary mb-3"style="cursor: pointer;">Ячейка №<?php echo $v['cell']; ?></span>
				    	<span class="badge badge-success mb-3"style="cursor: pointer;">Обьем <?php echo $v['volume']; ?>ML</span>
				    	<br>
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
			<div class="col-md-12">
				<h3 class="text-center mt-5">Ничего не найдено</h3>
			</div>
			<?php } ?>	
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
				<input type="hidden" name="action" value="add_assort">
				<input type="hidden" name="token" value="<?php echo $token2; ?>">
				<input type="hidden" name="id" value="" class="product-id">
				<div class="form-group">
					<label class="font-weight-bold">Название товара</label>
					<input type="text" name="name" required="" class="form-control tovar-name" placeholder="Введите название">
				</div>
				<div class="form-group">
					<label class="font-weight-bold">Номер ячейки</label>
					<input type="number" name="cell" required="" class="form-control tovar-cell" placeholder="Введите номер ячейки">
				</div>
				<div class="form-group">
					<label class="font-weight-bold">Номер Refan</label>
					<input type="number" name="refan" required="" class="form-control tovar-refan" placeholder="Введите номер Refan">
				</div>
				<div class="form-group">
					<label class="font-weight-bold">Объем</label>
					<input type="number" name="volume" required="" class="form-control tovar-volume" placeholder="Введите Объем">
				</div>
				<div class="form-group mt-1">
					<label class="font-weight-bold">Изображение</label>
					<input type="file" name="img" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file  tovar-img">
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
	function openModal(action,element) {
		if (action == 'add_tovar') {
			$('.tovar-modal .modal-title').text('Добавить товар');
			$('.tovar-modal input[name="action"]').val('add_assort');
			$('.tovar-modal .tovar-name').val('');
			$('.tovar-modal .tovar-cell').val('');
			$('.tovar-modal .tovar-refan').val('');
			$('.tovar-modal .tovar-volume').val('');
			$('.product-id').val('');
			$('.tovar-modal .tovar-img').attr('required','true');
			$('.tovar-modal .tovar-img').closest('.form-group').find('label').text("Изображение");
		}
		else if(action == 'change_tovar'){
			var name = element.find('.product-name').val(),
			cell = element.find('.product-cell').val(),
			volume = element.find('.product-volume').val(),
			refan = element.find('.product-refan').val();

			$('.tovar-modal .modal-title').text('Изменить товар');
			$('.tovar-modal input[name="action"]').val('change_assort');
			$('.tovar-modal input[name="token"]').val('<?php echo $token2; ?>');
			$('.tovar-modal .tovar-name').val(name);
			$('.tovar-modal .tovar-cell').val(cell);
			$('.tovar-modal .tovar-volume').val(volume);
			$('.tovar-modal .tovar-refan').val(refan);
			$('.tovar-modal .tovar-img').removeAttr('required');
			$('.tovar-modal .tovar-img').closest('.form-group').find('label').text("Изображение(не обязательно)");
			$('.product-id').val(element.attr('product-id'));
			
			

			console.log(name);


		}
		$('.tovar-modal').modal('show');
		
	}

	$('.change-button').click(function(event) {
		openModal('change_tovar',$(this).closest('.card'));
	});

	
	$('.remove-button').click(function () {
		var product_id = $(this).closest('.card').attr('product-id');
		$.post('engine2.php', {action: 'remove_assort', token: '<?php echo $token2; ?>',product_id: product_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).closest('.card').parent('div').hide();
	});
	$('.restore-button').click(function () {
		var product_id = $(this).closest('.card').attr('product-id');
		$.post('engine2.php', {action: 'restore_assort',token: '<?php echo $token2; ?>',product_id: product_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-secondary');
		$(this).addClass('disabled');
		$(this).text('Восстановлено');
	});
</script>
<?php include 'footer.php'; ?>