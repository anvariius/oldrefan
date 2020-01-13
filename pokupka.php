<?php 
include 'header.php'; 
if (!isset($_SESSION['basket']) && !isset($_SESSION['tovars'])) {
?>
<script>window.location.replace('index.php');</script>
<?php } ?>
<h3>оформить покупку</h3>
<div class="greyline1"></div>
<div class="wrap5">
	<div class="info pokupka">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form action="">
					<div class="form-group row">
					    <label class="col-sm-4 col-form-label">ИМЯ</label>
					    <div class="col-sm-7">
					      	<input type="text" class="form-control user-name" placeholder="ИМЯ">
					    </div>
				  	</div>
				  	<div class="form-group row">
				    	<label class="col-sm-4 col-form-label">номер телефона</label>
				    	<div class="col-sm-7">
					      	<input type="text" class="form-control user-phone" placeholder="номер телефона">
				    	</div>
				  	</div>
				  	<div class="form-group row">
				    	<label class="col-sm-4 col-form-label">Email</label>
				    	<div class="col-sm-7">
					      	<input type="text" class="form-control user-email" placeholder="email">
				    	</div>
				  	</div>
				  	<div class="form-group row sposob-oplaty">
				    	<label class="col-sm-4 col-form-label">способ оплаты</label>
				    	<div class="col-sm-8">
				    		<?php if ($_SESSION['tovars']['dostavka'] == 'курьер') { ?>
				      		<div class="form-check">
				        		<input class="form-check-input kurkur seccc" type="checkbox" id="gridCheck1" checked="">
				        		<label class="form-check-label">
				          			Оплата картой курьеру при получении
				        		</label>
				      		</div>
				      		<?php }else{ ?>
				      		<div class="form-check">
				        		<input class="form-check-input pakopako seccc" type="checkbox" id="gridCheck2" checked="">
				        		<label class="form-check-label">
				          			Оплата картой в пакомате Omniva при получении
				        		</label>
				      		</div>
				      		<?php } ?>
				      		<div class="form-check">
				        		<input class="form-check-input bankbank" type="checkbox" id="gridCheck3">
				        		<label class="form-check-label">
				          			Перевод на банковский счет
				        		</label>
				      		</div>
				    	</div>
				  	</div>
				  	
				</form>
				<div class="buttons">
					<button class="close-popup white" onclick="toPage('basket.php');">назад</button>
					<button class="pokupka-button" onclick="gtag_report_conversion1()">заказать</button>
				</div>
				<div class="row">
					<div class="col-md-10 offset-md-1">
						<span class="politica text-muted">Оформив заказ, вы соглашаетесь с <a href="pravila.php">правилами пользования</a> и <a href="politica.php">политикой конфиденциальности</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<img src="img/visamastercard.png" alt="" class="sposoboplaty third">

<?php include 'footer.php'; ?>