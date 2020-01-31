<?php 
include 'header.php'; 

$feedback = sequery("SELECT id,name,city,tovar,message,DATE_FORMAT(data,'%d.%m.%Y') AS data FROM feedback WHERE status = 2");
if (count($feedback) == 0) {
	$feedback = false;
}
elseif (!isset($feedback[0]['id'])) {
	$feedback = array('1' => $feedback);
}
?>
<style>
	.selectImg{
		height: 169px;
		width: 169px;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		display: flex;
		align-items: center;
		text-align: center;
		justify-content: center;
		cursor: pointer;
		margin-right: 10px;
		position: relative;
	}
	.selectImg p{
		margin-bottom: 0;
		color: #495057;
		display: block;
	}
	.removeImg{
		opacity: 0;
	    display: none;
	    position: absolute;
	    width: 100%;
	    height: 100%;
	    top: 0;
	    background: rgba(0,0,0,0.6);
	    font-size: 24px;
	    color: #fff;
	    -webkit-transition: all 0.3s;
	    transition: all 0.3s;
	    z-index: 22;
	}
	.removeImg i{
		top: calc(50% - 8px);
		right: calc(50% - 8px);
		position: absolute;
	}
	.removeImg:hover{
		opacity: 1;
	}
	.img-wrap{
		display: flex;
		justify-content: flex-start;
	}
</style>
<h3>Добавить отзыв</h3>
<div class="greyline1"></div>
<div class="wrap5">
	<div class="row">
		<div class="col-md-12">
			<form class="user-info" method="post" action="engine.php" enctype="multipart/form-data">
				<input type="hidden" name="action" value="add_feedback">
				<input type="text" name="invis" style="display: none;">
				<input type="checkbox" name="hehehe" style="display: none;">
				<div class="form-row">
					<div class="col">
						<label>Имя</label>
						<input type="text" class="form-control" placeholder="Введите имя" name="name" required="" maxlength="100">
					</div>
					<div class="col">
						<label>Email</label>
						<input type="email" class="form-control" placeholder="Введите email" name="email" maxlength="100">
					</div>
				</div>
				<div class="form-row mt-3">
				</div>
				<div class="form-row mt-3">
					<div class="col">
						<label>Город</label>
						<input type="text" class="form-control" placeholder="Введите город" name="city" maxlength="60">
					</div>
					<div class="col">
						<label>Название товара</label>
						<input type="text" class="form-control" placeholder="Введите название" name="tovar" maxlength="100">
					</div>
				</div>
				<div class="form-row mt-3">
					<div class="col">
						<label>Ваше сообщение</label>
						<textarea rows="10" type="text" class="form-control" placeholder="Введите сообщение" name="message" required="" maxlength="6000"></textarea>
					</div>
				</div>
				
				<div class="form-row mt-3">
					<div class="col">
						<label>Изображения</label>
						<div class="img-wrap">	
							<div class="fileimg-block">
								<input type="file" style="display: none;" name="img[]" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
								<div class="selectImg" is-added="false">
									<p>Загрузить фото</p>
									<div class="removeImg">
										<i class="fa fa-remove"></i>
									</div>
								</div>									
							</div>
							<div class="fileimg-block">
								<input type="file" style="display: none;" name="img[]" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
								<div class="selectImg" is-added="false">
									<p>Загрузить фото</p>
									<div class="removeImg">
										<i class="fa fa-remove"></i>
									</div>
								</div>									
							</div>
							<div class="fileimg-block">
								<input type="file" style="display: none;" name="img[]" accept="image/x-png,image/gif,image/jpeg" class="form-control-file">
								<div class="selectImg" is-added="false">
									<p>Загрузить фото</p>
									<div class="removeImg">
										<i class="fa fa-remove"></i>
									</div>
								</div>									
							</div>
						</div>
						
					</div>
				</div>
				<div class="form-row mt-3">
					<div class="col-md-3 offset-md-9 col-6 offset-6">
						<button type="submit" class="btn btn-warning btn-block save-settings">Отправить</button>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
	$('.selectImg').click(function () {
	    if ($(this).attr('is-added') == 'false') {
	        $(this).closest('.fileimg-block').find('input[type="file"]').trigger('click');
	        $(this).attr('is-added','true');
	    }
	    else{
	        $(this).closest('.fileimg-block').find('input[type="file"]')[0].value = "";
	        $(this).css('background-image', 'none');
	        $(this).find('p').show();
	        $(this).find('.removeImg').hide();
	        $(this).attr('is-added','false');
	        console.log($(this).closest('.fileimg-block').find('input[type="file"]')[0].files);
	    }
	    
	});

	$('input[type="file"]').change(function() {
	    var reader = new FileReader(),
	    file = this.files[0], div = $(this).closest('.fileimg-block').find('.selectImg');
	    reader.onloadend = function() {
	        div.css('background-image', 'url(' + this.result + ')');
	        div.find('p').hide();
	        div.find('.removeImg').show();
	    }
	    file ? reader.readAsDataURL(file) : div.css('background', 'none');

	    console.log($(this)[0].files);
	});
</script>
<?php include 'footer.php'; ?>