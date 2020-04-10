<?php 
include 'header.php';
$kosmetica = sequery("SELECT * FROM kosmetica WHERE status != 0");
?>
<div class="container">
	<div class="row">
		<?php foreach ($kosmetica as $v) { ?>
		<div class="col-sm-6">
			<div class="razdel-parent">
				<div class="razdel-banner" linkto="<?php echo $v['link'] ?>" style="background-image: url(media/<?php echo $v['img_url'] ?>);">
					<div class="shadow">
						<div>
						<h3><?php echo $v['name'] ?></h3>
						<div class="line"></div>
						</div>
					</div>
				</div>
				<p style="display: none;"><?php echo $v['descr'] ?></p>
				<div class="showdescr" showed="false">Описание линии <span class="fa fa-angle-down"></span></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<script>
	$('.showdescr').click(function () {
		if ($(this).attr('showed') == 'false') {
			$(this).closest('.razdel-parent').find('p').slideDown();
			$(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
			$(this).attr('showed','true');
		}
		else{
			$(this).closest('.razdel-parent').find('p').slideUp();
			$(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
			$(this).attr('showed','false');
		}
	});
</script>
<?php include 'footer.php'; ?>