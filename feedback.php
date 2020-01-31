<?php 
include 'header.php'; 

$feedback = sequery("SELECT id,name,city,tovar,message,answer,DATE_FORMAT(data,'%d.%m.%Y') AS data FROM feedback WHERE status = 2 ORDER BY data DESC");
if (count($feedback) == 0) {
	$feedback = false;
}
elseif (!isset($feedback[0]['id'])) {
	$feedback = array('1' => $feedback);
}
?>
<style>
	.fb-imgwrap{
		display: flex;
		align-items: center;
		justify-content: flex-start;

	}
	.fb-imgwrap a{
		margin-right: 10px;
		display: block;
		text-decoration: none;
		height: 120px;
		width: 120px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		border-radius: 10px;
	}
	.fb-name{
		margin-bottom: 5px;
	}
	.fb-text span{
		font-weight: bold;
		color: #ffc107;
	}
</style>
<h3>Отзывы покупателей</h3>
<div class="greyline1"></div>
<div class="wrap5">
	<div class="row">
		<div class="col-md-12">
			<h4>Здесь вы можете прочитать отзывы и оставить свой отзыв о покупке</h4>
			<a href="add-feedback.php" class="btn btn-lg btn-warning d-block mt-3">Оставить отзыв</a>
			<hr>
			<?php 	
				foreach ($feedback as $v) {
					$fb_id = $v['id'];
					$fb_img = sequery("SELECT * FROM fb_img WHERE fb_id=:fb_id AND status != 0", compact('fb_id'));
					if (count($fb_img) == 0) {
						$fb_img = [];
					}
					elseif (!isset($fb_img[0]['id'])) {
						$fb_img = array('1' => $fb_img);
					}
			?>
				<div class="row fb-block">
					<div class="col-md-3">
						<p class="fb-name"><?php echo $v['name'] ?></p>
						<p class="fb-name"><?php echo $v['city'] ?></p>
						<p class="fb-name"><?php echo $v['data'] ?></p>
					</div>
					<div class="col-md-9">
						<h4 class="fb-title"><?php echo $v['tovar']; ?></h4>
						<p class="fb-text"><?php echo $v['message']; ?></p>
						<div class="fb-imgwrap">
							<?php foreach ($fb_img as $w) { ?>
							<a href="feedback/<?php echo $w['img_url'] ?>" class="lightzoom" target="_blank" style="background-image: url(feedback/<?php echo $w['img_url'] ?>);"></a>
							<?php } ?>
						</div>
						<?php if($v['answer'] != ''){ ?>
						<p class="fb-text mt-3"><span>RefanParfum: </span><?php echo $v['answer']; ?></p>
						<?php } ?>
					</div>
				</div>
				<hr>
			<?php } ?>
		</div>
	</div>	
</div>
<?php include 'footer.php'; ?>
<?php if(isset($_GET['sended'])){ ?>
<script>
	$('#subs-alert strong').text("Ваш отзыв будет добавлен после проверки администратором");
	$('#subs-alert').fadeIn('slow');
	timer=setTimeout(function() { $('#subs-alert').fadeOut('slow'); }, 5000);
</script>
<?php } ?>