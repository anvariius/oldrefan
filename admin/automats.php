<?php 
include '../bt/pdo.php';
include 'header.php';

if (isset($_GET['category'])) {
	$category = $_GET['category'];	
}
else{
	$category = 'automats';
}

switch ($category) {
	case 'automats':
		$qtext = 'Торговые автоматы';
		$query = sequery("SELECT * FROM pakomats WHERE status = 1 ORDER BY ordering ASC");
		$automat_id = '1';
		break;
	case 'assorti':
		$qtext = 'Ассортимент автоматов';
		$automat_id = $_GET['automat-id'];
		$query = sequery("SELECT * FROM assortiment WHERE automat_id=:automat_id AND status = 1", compact('automat_id'));
		$automats = sequery("SELECT * FROM pakomats WHERE status = 1");
		break;
	default:
		# code...
		break;
}

if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}

?>
<style>
	img{
		width: 100%;
	}
	iframe{
		width: 100%;
		height: 200px;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			      	<a class="nav-link <?php if($category == 'automats'){echo 'active';} ?>" href="automats.php">Торговые автоматы</a>
			      	<a class="nav-link <?php if($category == 'assorti'){echo 'active';} ?>" href="automats.php?category=assorti&automat-id=1">Ассортимент автоматов</a>
			      	<?php if($category == 'automats'){ ?>
			      	<button class="btn btn-success btn-block add-automat mt-5" onclick="openModal('automat_add');">Добавить автомат</button>
			      	<?php } ?>
			    </div>
			
		</div>
		<div class="col-md-9">
			<h3 class="text-center mb-5"><?php echo $qtext; ?></h3> 
			<?php if($category == 'automats'){ ?>
			<?php if($query){ foreach ($query as $v) { ?>
			<div class="row pakomat-block" pakomat-id='<?php echo $v['id']; ?>'>
				<input type="hidden" class="a-id" value='<?php echo $v['id']; ?>'>
				<input type="hidden" class="a-adress" value='<?php echo $v['adress']; ?>'>
				<input type="hidden" class="a-info" value='<?php echo str_replace("<br />", "", $v['info']); ?>'>
				<input type="hidden" class="a-frame" value="<?php echo htmlspecialchars($v['map_frame']); ?>">
				<div class="col-md-12">
					<h4 class="mb-2"><?php echo $v['adress']; ?></h4>
				</div>
				<div class="col-md-8">
					<img src="../pakomats/<?php echo $v['img_outside']; ?>" alt="" class="mb-3">
					<p><?php echo $v['info']; ?></p>
					<div class="row">
						<div class="col-md-6">
							<button class="btn btn-primary btn-block change-button">Изменить</button>
						</div>
						<div class="col-md-6">
							<button class="btn btn-danger btn-block remove-button">Удалить</button>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<img src="../pakomats/<?php echo $v['img_inside']; ?>" alt="" class="mb-3">
					<?php echo $v['map_frame']; ?>
				</div>
			</div>
			<hr>
			<?php }}else{ ?>
				<h4 class="text-center mb-5">Нет торговых автоматов</h4>
			<?php } ?>
			<?php }elseif ($category == 'assorti'){ ?>	
			<div class="row">
				<div class="col-md-4 offset-md-1"><h5>Выберите адрес автомата</h5></div>
				<div class="col-md-5">
					<select class="form-control mb-4 select-automat" style="display: none;">
						<?php foreach ($automats as $v) { ?>
						<option value="<?php echo $v['id']; ?>"><?php echo $v['adress']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-10 offset-md-1">
					
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>№</th>
								<th>Refan</th>
								<th>Название</th>
								<th>Цена</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $k = 1; ?>
							<?php if($query != false){ foreach ($query as $v) {  ?>
							<tr>
								<input type="hidden" class="ass-id" value="<?php echo $v['id']; ?>">
								<td><?php echo $k; ?></td>
								<td><?php echo $v['refan']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['price']; ?>€</td>
								<td><button class="btn btn-block btn-danger remove-ass">Удалить</button></td>	
							</tr>
							<?php $k++; }} ?>
							<tr class="new-ass">
								<td><?php echo $k; ?></td>
								<td><input type="text" class="ass-refan form-control"></td>
								<td><input type="text" class="ass-name form-control"></td>
								<td>
									<div class="input-group">
										<input type="text" class="ass-price form-control">
										<div class="input-group-append">
											<div class="input-group-text">€</div>
										</div>
									</div>
									
								</td>
								<td><button class="btn btn-block btn-primary add-acs">Добавить</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>	
			<?php } ?>
		</div>
	</div>
</div>
<div class="modal automat-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title">Добавить автомат</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<div class="modal-body">
			<form action="engine2.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="add_automat">
				<input type="hidden" name="token" value="<?php echo $token2; ?>">
				<input type="hidden" name="id" value="" class="automat-id">
				<div class="form-group">
					<label class="font-weight-bold">Адрес автомата</label>
					<input type="text" name="adress" required="" class="form-control automat-adress" placeholder="Введите адрес">
				</div>
				<div class="form-group">
					<label class="font-weight-bold">Информация</label>
					<textarea name="info" class="form-control automat-info" placeholder="Введите информацию" cols="30" rows="10"></textarea>
				</div>
				<div class="form-group">
					<label class="font-weight-bold">Код вставки карты</label>
					<input type="text" name="map_frame" required="" class="form-control automat-frame" placeholder="Введите код карты">
				</div>
				<div class="form-group mt-1">
					<label class="font-weight-bold">Изображение снаружи</label>
					<input type="file" name="img_outside" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file automat-outside">
				</div>
				<div class="form-group mt-1">
					<label class="font-weight-bold">Изображение изнутри</label>
					<input type="file" name="img_inside" required="" accept="image/x-png,image/gif,image/jpeg" class="form-control-file automat-inside">
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
		if (action == 'automat_add') {
			$('.automat-modal .modal-title').text('Добавить автомат');
			$('.automat-modal .automat-adress').val('');
			$('.automat-modal .automat-info').val('');
			$('.automat-modal .automat-frame').val('');
			$('.automat-modal input[name="action"]').val('add_automat');
			$('.automat-modal input[name="token"]').val('<?php echo $token2; ?>');
			$('.automat-modal .automat-inside').attr('required','true');
			$('.automat-modal .automat-inside').closest('.form-group').find('label').text("Изображение внутри");
			$('.automat-modal .automat-outside').attr('required','true');
			$('.automat-modal .automat-outside').closest('.form-group').find('label').text("Изображение снаружи");
			$('.automat-id').val('');
		}
		else if(action == 'automat_change'){
			var adress = element.find('.a-adress').val(),
			id = element.find('.a-id').val(),
			info = element.find('.a-info').val(),
			frame = element.find('.a-frame').val();

			$('.automat-modal .modal-title').text('Изменить автомат');
			$('.automat-modal .automat-adress').val(adress);
			$('.automat-modal .automat-info').val(info);
			$('.automat-modal .automat-frame').val(frame);
			$('.automat-modal input[name="action"]').val('change_automat');
			$('.automat-modal input[name="token"]').val('<?php echo $token2; ?>');
			$('.automat-modal .automat-inside').removeAttr('required');
			$('.automat-modal .automat-inside').closest('.form-group').find('label').text("Изображение внутри (не обязательно)");
			$('.automat-modal .automat-outside').removeAttr('required');
			$('.automat-modal .automat-outside').closest('.form-group').find('label').text("Изображение снаружи (не обязательно)");
			$('.automat-id').val(id);

			//console.log(name);


		}
		$('.automat-modal').modal('show');
		
	}

	$('.select-automat option[value="<?php echo $automat_id; ?>"]').attr("selected", "selected");
	$('.select-automat').show();

	$('.change-button').click(function(event) {
		openModal('automat_change',$(this).closest('.pakomat-block'));
	});

	$('.remove-button').click(function () {
		var automat_id = $(this).closest('.pakomat-block').attr('pakomat-id');
		$.post('engine2.php', {action: 'remove_automat',token: '<?php echo $token2; ?>',automat_id: automat_id}, function(data, textStatus, xhr) {
			//console.log(data);			
		});
		$(this).closest('.pakomat-block').hide();
	});
	$('.add-acs').click(function(event) {
		$('.new-ass input').removeClass('is-invalid');
		var valid = true;
		if ($('.ass-name').val() == '') {
			$('.ass-name').addClass('is-invalid');
			valid = false;
		}
		if ($('.ass-refan').val() == '') {
			$('.ass-refan').addClass('is-invalid');
			valid = false;
		}
		if ($('.ass-price').val() == '') {
			$('.ass-price').addClass('is-invalid');
			valid = false;
		}
		if (valid == true) {
			$.post('engine2.php', {action: 'add_assorti', token: '<?php echo $token2; ?>', automat_id:"<?php echo $automat_id; ?>", refan: $('.ass-refan').val(), name: $('.ass-name').val(), price: $('.ass-price').val()}, function(data, textStatus, xhr) {
				//console.log(data);
				location.reload();
			});
		}
	});
	$('.select-automat').change(function(event) {
		var automat_id = $('.select-automat option:selected').val();
		location.replace('automats.php?category=assorti&automat-id='+automat_id);
	});


	$('.remove-ass').click(function(event) {
		var ass_id = $(this).closest('tr').find('.ass-id').val();
		$.post('engine2.php', {action: 'remove_assorti', token: '<?php echo $token2; ?>', ass_id: ass_id}, function(data, textStatus, xhr) {
				console.log(data);
				location.reload();
			});
	});
</script>
<?php include 'footer.php'; ?>