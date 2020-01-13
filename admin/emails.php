<?php 
include '../bt/pdo.php'; 
include 'header.php';
if (isset($_GET['action'])) {
	$action = $_GET['action'];
}
else{
	$action = 'show_emails';
}

switch ($action) {
	case 'show_emails':	
		$title = 'Список email';
		break;
	case 'send_emails':
		$title = 'Создание рассылки Email';
		break;
	case 'send_sms':
		$title = 'Создание рассылки SMS';
		break;
	default:
		# code...
		break;
}
$query = sequery("SELECT * FROM emails WHERE status = 1");
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
else{
	$query = array_reverse($query);
}
?>	
<style>
	.badge{
		position: absolute;
		z-index: 10001;
		float: left;
		margin-top: 25px;
		margin-left: 200px;
		cursor: pointer;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		      	<a class="nav-link <?php if($action == 'show_emails') echo 'active'; ?>" href="emails.php?action=show_emails">Список Контактов</a>
		      	<a class="nav-link <?php if($action == 'send_emails') echo 'active'; ?>" href="emails.php?action=send_emails">Создать рассылку Email</a>
		      	<a class="nav-link <?php if($action == 'send_sms') echo 'active'; ?>" href="emails.php?action=send_sms">Создать рассылку SMS</a>
		    </div>  	
		</div>
		<div class="col-md-9">
			<h3 class="text-center mb-5"><?php echo $title; ?></h3> 
			
			<?php if ($action == 'show_emails'){ ?>
				<?php $k = 0; if($query){?>
				<table class="table table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>№</th>
							<th>Телефон</th>
							<th>Email</th>
							<th>Действие</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>0</td>
							<td><input type="text" class="form-control new-phone" placeholder="Введите новый телефон" value=""></td>
							<td><input type="text" class="form-control new-email" placeholder="Введите новый Email" value=""></td>
							<td><button class="btn btn-primary btn-block add-email">Добавить</button></td>
						</tr>
						<?php foreach ($query as $v) { $k+=1; if($v['phone'] == ''){ $v['phone'] = 'не указано'; } ?>
						<tr email-id="<?php echo $v['id']; ?>" class="email-card">
							<td><?php echo $k; ?></td>
							<td><p><?php echo $v['phone']; ?></p></td>
							<td><p><?php echo $v['email']; ?></p></td>
							<td><button class="btn btn-danger btn-block remove-email">Удалить</button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			<?php }else if ($action == 'send_emails'){ ?>
			<?php if (!$query) { ?>	
				<h4>Нет доступных Контактов</h4>
			<?php }else{ ?>	
				<div class="row mailing">
				<div class="col-md-10 offset-md-1">
					<form action="engine2.php" method="POST" class="mailing-form" enctype="multipart/form-data">
						<input type="hidden" name="action" value="send_mailing">
						<input type="hidden" name="token" value="<?php echo $token2; ?>">
						<div class="form-group mb-3">
					    	<label>Название рассылки</label>
					    	<input type="text" required="" name="name" class="form-control form-control-lg" placeholder="Введите название">
					    	<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					  	</div>
					  	<div class="form-group mb-3">
					    	<label>Заголовок рассылки</label>
					    	<input type="text" required="" class="form-control form-control-lg" name="title" placeholder="Введите заголовок">
					    	<!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					  	</div>
					  	<div class="form-group mb-3">
					    	<label>Текст рассылки</label>
					    	<textarea name="text" cols="30" rows="10" class="form-control form-control-lg" required="" placeholder="Введите текст"></textarea>
					    	<!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					  	</div>
					  	<div class="form-group">
						    <label>Изображение</label>
						    <input type="file" name="img" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
					    	<small class="form-text text-muted">Необязательно</small>
					  	</div>
					  	<div class="form-group">
					  		<button type="submit" class="btn btn-primary btn-lg">Отправить</button>
					  	</div>
					</form>
				</div>
				</div>
			<?php } }else if ($action == 'send_sms') { ?>
			<?php if (!$query) { ?>	
			<h4>Нет доступных Контактов</h4>
			<?php }else{ ?>	
			<div class="row smsing">
				<div class="col-md-10 offset-md-1">
					<form action="engine2.php" method="POST" class="mailing-form" enctype="multipart/form-data">
						<input type="hidden" name="action" value="send_smsing">
						<input type="hidden" name="token" value="<?php echo $token2; ?>">
					  	<div class="form-group mb-3">
					    	<label>Текст рассылки</label>
					    	<textarea name="text" cols="30" rows="10" class="form-control form-control-lg" maxlength="140" required="" placeholder="Введите текст"></textarea>
					    	<small class="form-text text-muted typing">Количество символов: <span class="typing_num">0</span>, частей SMS: <span class="typing_parts">1</span></small>
					    	<small class="form-text text-muted">Стоимость одного смс одному пользователю 2,55 руб.</small>
					    	<small class="form-text text-muted">В тексте каждого сообщения по требованиям оператора необходимо указывать контактную информацию и обозначить вашу компанию.</small>
					  	</div>
					  	<div class="form-group">
					  		<button type="submit" class="btn btn-primary btn-lg">Отправить</button>
					  	</div>
					</form>
				</div>
			</div>	
		<?php }} ?>
		</div>
	</div>
</div>
<script src="../js/jquery.maskedinput.min.js"></script>
<script>
	var current_email,
		isButton = false;
	$('.remove-email').click(function(event) {
		var email_id = $(this).closest('.email-card').attr('email-id');
		$.post('engine2.php', {action: 'remove_email', token: '<?php echo $token2; ?>', email_id: email_id}, function(data, textStatus, xhr) {
			console.log(data);
		});
		$(this).closest('.email-card').slideUp('fast');
	});
	

	$('.add-email').click(function(event) {
		var new_email = $('.new-email').val();
		var new_phone = $('.new-phone').val();
		$.post('engine2.php',{action: 'add_email', token: '<?php echo $token2; ?>', new_email: new_email, new_phone: new_phone},function () {
			location.reload();
		});
	});

	$('.smsing .mailing-form textarea').keyup(function () {
	  $('.typing_num').text($(this).val().length);

	  if ($(this).val().length > 70) {
	  	$('.typing_parts').text('2');
	  }
	  else{
	  	$('.typing_parts').text('1');
	  }
	});

	$(".new-phone").mask("+379  99999?999");
			
</script>
<?php include 'footer.php'; ?>	
