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
						    <input type="file" name="img" accept="image/x-png,image/gif,image/jpeg" class="form-control-file mailimgg">
					    	<small class="form-text text-muted">Необязательно</small>
					  	</div>
					  	<div class="form-group">
					  		<label>Список адресатов</label>
					  		<?php $k = 0; if($query){ ?>
					  		<div style="max-height:700px;height:auto;overflow-y:scroll;">	
							<table class="table table-bordered">
								<thead class="thead-dark">
									<tr>
										<th>№</th>
										<th>Email</th>
										<th>Выбрать</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="2">Выбрать все</td>
										<td><input type="checkbox" class="check-all"></td>
									</tr>
									<?php foreach ($query as $v) { $k+=1; if($v['phone'] == ''){ $v['phone'] = 'не указано'; } ?>
									<tr email-id="<?php echo $v['id']; ?>" class="email-card">
										<td><?php echo $k; ?></td>
										<td><p><?php echo $v['email']; ?></p></td>
										<td><input type="checkbox" class="check-email"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							</div>
							<?php } ?>
					  	</div>
					  	<div class="form-group">
					  		<label>Адресатов: <span class="email-count">0</span></label>
					  	</div>
					  	<div class="form-group">
					  		<button type="button" class="btn btn-primary btn-lg send-email">Отправить</button>
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


	$('.check-all').click(function () {
		if ($(this).is(':checked')) {
			$('.check-email').prop('checked', true);
		}
		else{
			$('.check-email').prop('checked', false);
		}
		
	});
	$('.check-all, .check-email').click(function () {
		$('.email-count').text($('.check-email:checked').length);
	});

	var isend = false;
	var isStarted = false;
	var checked_emails = [];
	let timerId;
	var statline = $('.stats-table .statline').clone();
	var isImg = 'false';
	var img_name = '';

	$('.mailimgg').change(function () {
		isImg = 'true';
	});

	$('.send-email').click(function (e) {
		e.preventDefault();

		$('.mailing input, .mailing textarea').removeClass('is-invalid');
		$('.email-count').parent().removeClass('text-danger');


		var file_data = $('.mailimgg').prop('files')[0];
	    var form_data = new FormData();
	    form_data.append('file', file_data);
	    form_data.append('action', 'uploadImageUni');
	    form_data.append('token', '<?php echo $token2; ?>');
	    $.ajax({
	        url: 'engine2.php',
	        dataType: 'text',
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: form_data,
	        type: 'post',
	        success: function(php_script_response){
	            img_name = php_script_response;
	            console.log(img_name);
	        }
	     });


		var formValid = true,
			eName = $('.mailing input[name="name"]'),
			eTitle = $('.mailing input[name="title"]'),
			eText = $('.mailing textarea[name="text"]');
		checked_emails = [];	


		$('.check-email:checked').each(function () {
			checked_emails.push($(this).closest('.email-card').attr('email-id'));
		});
		var emails_length = checked_emails.length;	
		
		if (eName.val() == '') {
			eName.addClass('is-invalid');
			formValid = false;
		}
		if (eText.val() == '') {
			eText.addClass('is-invalid');
			formValid = false;
		}	
		
		if (emails_length == 0) {
			$('.email-count').parent().addClass('text-danger');
			formValid = false;
		}

		if(formValid == true){

		
		isStarted = true;
		
		var i = 0;
		var j;
		$('.etosend').text(emails_length);
		$('.emails-modal').modal('show');

		timerId = setInterval(function () {
			isend = false;

			j = i + 5;
			if (j > emails_length) {
				j = emails_length;
				isend = true;
			}

			while(i < j){
				$.post('engine2.php',{action:'sendEmailUni', token: '<?php echo $token2; ?>',email_id:checked_emails[i], name: eName.val(), title: eTitle.val(), text: eText.val(), isImg: isImg,img_name: img_name}, function (data) {
					data = JSON.parse(data);
					var stts = "Отправлено";
					if (data.result == '') {
						stts = "Ошибка";
					}

					$('.stats-table tbody').prepend('<tr class="statline"><td class="st_email">'+data.email+'</td><td class="st_status">'+stts+'</td></tr>');
				});
				i++;
			}

			$('.esended').text(i);
			var valuenow = Math.ceil(i*100/emails_length);
			if (valuenow>100) {valuenow = 100;}
			$('.emails-modal .progress-bar').attr('aria-valuenow', valuenow);
			$('.emails-modal .progress-bar').css('width',valuenow+'%');
			$('.emails-modal .progress-bar').text(valuenow+'%');

			if (isend == true) {
				clearInterval(timerId);
				
				console.log('clearInterval');
				$('.etext').text('Завершено');
				$('.break-sending').removeClass('btn-danger').addClass('btn-primary').text("Закрыть");
			}
		}, 5000);

		}
		
	});


	$(document).on('click', '.brkk', function (e) {
		if (isend == false) {
			if(confirm("Вы действительно хотите прервать рассылку?")){
				location.reload();
			}
		}
		else{
			location.reload();
		}
	});



			
</script>


<div class="modal emails-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Рассылка email</h5>
				<button type="button" class="close" aria-label="Close">
				<span class="brkk" aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4><span class="etext">В процессе</span> <span class="esended">0</span> / <span class="etosend"></span></h4>
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div style="height: auto; max-height: 400px; overflow-y: auto; margin-top: 20px;">
					<table class="table stats-table">
						<thead class="thead-light">
							<tr>
							<th scope="col">Email</th>
							<th scope="col">Статус</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger break-sending brkk">Прервать</button>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>	
