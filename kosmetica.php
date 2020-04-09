<?php 
include 'header.php';
$kosmetica = sequery("SELECT * FROM kosmetica WHERE status != 0");
?>
<div class="container">
	<div class="row">
		<?php foreach ($kosmetica as $v) { ?>
		<div class="col-sm-6">
			<div class="razdel-banner" style="background-image: url(media/<?php echo $v['img_url'] ?>);" linkto="<?php echo $v['link'] ?>">
				<div class="shadow">
					<div>
					<h3><?php echo $v['name'] ?></h3>
					<div class="line"></div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>