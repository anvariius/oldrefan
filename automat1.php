<?php include 'header.php'; ?>
<?php

$query = sequery("SELECT * FROM pakomats WHERE status = 1 ORDER BY ordering ASC");
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}


?>
<style>
	.automats .pakomat-block{
		display: none;
		margin-top: 30px;
	}
	.automats .pakomat-block.active{
		display: flex;
	}
	iframe{
		width: 100% !important;
		height: 300px !important;
	}
	h5{
		color: #edbe3c;
		font-family: Montserrat;
	}
	select{
		width: 100%;
	}
	table{
		font-family: Montserrat;
	}
	
</style>
<h3>Торговые автоматы</h3>
<div class="greyline1"></div>
<div class="wrap5">
	<div class="info garanty automats">
		<div class="row assortt">
			<div class="col-md-4">
				<img src="img/automatikk.jpg" alt="">
			</div>
			<div class="col-md-8 flex align-items-center">
				<div>
					<h4>Пошаговая инструкция по работе с торговым автоматом</h4>
					<a href="ta_instrukcija.php">refanparfum.lv/ta_instrukcija.php</a>
					<h4>Ассортимент торговых автоматов находится на странице</h4>
					<a href="assortiment.php">refanparfum.lv/assortiment.php</a>
				</div>
			</div>
		</div>
		<?php foreach ($query as $v) { ?>
			<div class="row pakomat-block active" pakomat-id="<?php echo $v['id']; ?>">
				<div class="col-md-12">
					<h5><?php echo $v['adress'] ?></h5>
				</div>
				<div class="col-md-8">
					<img src="pakomats/<?php echo $v['img_outside'] ?>" alt="" class="mb-3">
					<p><?php echo $v['info']; ?></p>
					<?php
					$automat_id = $v['id'];
					$query1 =  sequery("SELECT * FROM assortiment WHERE automat_id=:automat_id AND status = 1", compact('automat_id'));
					if (count($query1) == 0) {
						$query1 = false;
					}
					elseif (!isset($query1[0]['id'])) {
						$query1 = array('1' => $query1);
					}
					if($query1 != false){
					?>
					
					<table class="table table-bordered">
						<thead class="thead-light">
							<tr>
								<th>№</th>
								<th>Refan</th>
								<th>Название</th>
								<th>Цена</th>
							</tr>
						</thead>
						<tbody>
							<?php $k = 1; ?>
							<?php  foreach ($query1 as $v) {  ?>
							<tr>
								<input type="hidden" class="ass-id" value="<?php echo $v['id']; ?>">
								<td><?php echo $k; ?></td>
								<td><?php echo $v['refan']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['price']; ?>€</td>	
							</tr>
							<?php $k++; } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				<div class="col-md-4">
					<img src="pakomats/<?php echo $v['img_inside'] ?>" alt="" class="mb-3">
					<?php echo $v['map_frame']; ?>
				</div>
			</div>
		<?php } ?>
	</div>	
</div>
<script>
	$('.automats select').change(function(event) {
		var row_id = $('.automats .active select option:selected').val();
		$(".automats select [value='"+row_id+"']").attr("selected", "selected");
		$('.automats .pakomat-block').removeClass('active');
		$('.automats .pakomat-block[pakomat-id="'+row_id+'"]').addClass('active');
		console.log($('.automats select option:selected').text());
	});
</script>
<button class="clientprav">Клиент для Нас всегда на первом месте!</button>
<?php include 'footer.php'; ?>