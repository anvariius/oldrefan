<?php
include '../bt/pdo.php';
include 'header.php';
$fb_new = sequery("SELECT id,name,city,tovar,message,DATE_FORMAT(data,'%d.%m.%Y') AS data FROM feedback WHERE status = 1");
$fb_old = sequery("SELECT id,name,city,tovar,message,DATE_FORMAT(data,'%d.%m.%Y') AS data FROM feedback WHERE status = 2 ORDER BY data DESC");
if (count($fb_new) == 0) {
	$fb_new = false;
}
elseif (!isset($fb_new[0]['id'])) {
	$fb_new = array('1' => $fb_new);
}
if (count($fb_old) == 0) {
	$fb_old = false;
}
elseif (!isset($fb_old[0]['id'])) {
	$fb_old = array('1' => $fb_old);
}
?>
<style>
	.jumbotron{
		padding: 2rem;
	}
	.fb-imgwrap {
	    display: flex;
	    align-items: center;
	    justify-content: flex-start;
	}
	.fb-imgwrap a {
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
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Новые комментарии</h3>
			<hr>
			<?php 
			if($fb_new == false){echo "<p>Пусто</p>";}
			foreach($fb_new as $v){ 
				$fb_id = $v['id'];
				$fb_img = sequery("SELECT * FROM fb_img WHERE fb_id=:fb_id AND status != 0", compact('fb_id'));
				if (count($fb_img) == 0) {
					$fb_img = [];
				}
				elseif (!isset($fb_img[0]['id'])) {
					$fb_img = array('1' => $fb_img);
				}
			?>

			<div class="jumbotron" product-id="<?php echo $v['id'] ?>">
				<h2><?php echo $v['tovar'] ?></h2>
				<h5><?php echo $v['name'] ?> – <?php echo $v['data'] ?></h5>
				<p class="lead"><?php echo $v['message'] ?></p>
				<hr class="my-4">
				<div class="fb-imgwrap">
					<?php foreach ($fb_img as $w) { ?>
					<a href="../feedback/<?php echo $w['img_url'] ?>" class="lightzoom" style="background-image: url(../feedback/<?php echo $w['img_url'] ?>);"></a>
					<?php } ?>
				</div>
				<hr class="my-4">
				<a class="btn btn-primary fb-access" href="#">Одобрить</a>
				<a class="btn btn-danger fb-remove" href="#">Удалить</a>
				</p>
			</div>
			<?php } ?>
			<br>
			<h3>Одобренные комментарии</h3>
			<hr>
			<?php 
			if($fb_old == false){echo "<p>Пусто</p>";}
			foreach($fb_old as $v){ 
				$fb_id = $v['id'];
				$fb_img = sequery("SELECT * FROM fb_img WHERE fb_id=:fb_id AND status != 0", compact('fb_id'));
				if (count($fb_img) == 0) {
					$fb_img = [];
				}
				elseif (!isset($fb_img[0]['id'])) {
					$fb_img = array('1' => $fb_img);
				}
			?>
			<div class="jumbotron" product-id="<?php echo $v['id'] ?>">
				<h2><?php echo $v['tovar'] ?></h2>
				<h5><?php echo $v['name'] ?> – <?php echo $v['data'] ?></h5>
				<p class="lead"><?php echo $v['message'] ?></p>
				<hr class="my-4">
				<div class="fb-imgwrap">
					<?php foreach ($fb_img as $w) { ?>
					<a href="../feedback/<?php echo $w['img_url'] ?>" class="lightzoom" style="background-image: url(../feedback/<?php echo $w['img_url'] ?>);"></a>
					<?php } ?>
				</div>
				<hr class="my-4">
				<a class="btn btn-danger fb-remove" href="#">Удалить</a>
				</p>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
include 'footer.php';
?>
<script>
	$('.fb-remove').click(function () {
		var fb_id = $(this).closest('.jumbotron').attr('product-id');
		$.post('engine2.php', {token:'<?php echo $token2; ?>', action: 'fb_remove', fb_id: fb_id}, function (data) {
			location.reload();
		});
	});
	$('.fb-access').click(function () {
		var fb_id = $(this).closest('.jumbotron').attr('product-id');
		$.post('engine2.php', {token:'<?php echo $token2; ?>', action: 'fb_access', fb_id: fb_id}, function (data) {
			location.reload();
		});
	});
</script>