<?php
if (isset($_COOKIE['auth']) && $_COOKIE['auth'] == 'acrqc9') {
	header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Вход в панель управления</title>
	<link rel="stylesheet" href="../css/style.css">
  	<link rel="stylesheet" href="../css/bootstrap.min.css">
  	<link rel="stylesheet" href="../css/font-awesome.min.css">
  	<script src="../js/jquery-3.0.0.min.js" charset="utf-8"></script>
  	<script src="../js/bootstrap.min.js" charset="utf-8"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4">
				<form class="mt-5 pt-5">
					<h4 class="text-center mb-4">Вход в панель управления</h4>
			  		<div class="form-group">
			    		<label>Логин</label>
			    		<input type="text" class="form-control input-lg" placeholder="Введите логин">
			  		</div>
			  		<div class="form-group">
			    		<label>Пароль</label>
			    		<input type="password" class="form-control input-lg" placeholder="Введите пароль">
			  		</div>
			  		<button type="button" class="btn btn-primary btn-lg btn-block">Войти</button>
				</form>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).on('click','form button',function () {
		$('form input').removeClass('is-invalid');
		var flag = true,
			login = $('form input[type=text]'),
			password = $('form input[type=password]');
		if (login.val() == '') {
			login.addClass('is-invalid');
			flag = false;
		}
		if (password.val() == '') {
			password.addClass('is-invalid');
			flag = false;
		}
		if (flag == true) {
			
			$.post('../engine.php', {action: 'auth', login: login.val(), password: password.val()}, function(data) {
				if (data == 'invalid_form') {
					login.addClass('is-invalid');
					password.addClass('is-invalid');
				}
				else if (data == 'invalid_login') {
					login.addClass('is-invalid');
				}
				else if(data == 'invalid_password'){
					password.addClass('is-invalid');
				}
				else{
					window.location.replace('main.php');
				}
			});
		}
	});
</script>
</html>