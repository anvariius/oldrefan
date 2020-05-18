<?php 
include 'header.php'; 
$query = sequery("SELECT * FROM assort WHERE status = 1 ORDER BY cell");
if (count($query) == 0) {
	$query = false;
}
elseif (!isset($query[0]['id'])) {
	$query = array('1' => $query);
}
?>
<style>
	main .catalog{
		width: 100%;
	}
	.prod-card{
		border: 2px solid #000;
		margin-top: 15px;
		cursor: pointer;
	}
	.prod-card .img-block{
		height: 150px;
		background-size: 100%;
		background-position: center;
		background-repeat: no-repeat;
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
	}
	.prod-card .prod-num{
		max-height: 60px;
		max-width: 60px;
		padding: 5px 2px;
		background-color: rgba(0, 0, 0, 0.5);
		
	}
	.prod-card .volume-num{
		height: 40px;
		width: 40px;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		align-items: center;
		justify-content: center;
		
	}
	.prod-card .volume-num span{
		color: #fff;
		font-family: Montserrat;
		font-size: 12px;
		text-align: center;
	}
	.prod-num span{
		color: #fff;
		font-family: Montserrat;
		font-size: 11px;
		text-align: center;
		text-transform: uppercase;
		display: inline-table;
	}
	.prod-num span.num-wrap{
		font-size: 11px;

	}
	.prod-num span.num-wrap .num{
		font-size: 16px;
	}
	.prod-card .pname{
	    color: #000000;
    	font-family: Montserrat;
    	font-size: 13px;
    	font-weight: 700;
    	text-transform: uppercase;
    	text-align: center;
    	height: 55px;
	    overflow: hidden;
    	text-overflow: clip;
    	margin-bottom: 0;
    	line-height: 14px;	
	}
	.prod-card .prefan{
		color: #000000;
    	font-family: Montserrat;
    	font-size: 13px;
    	font-weight: 700;
    	text-transform: uppercase;
    	text-align: center;
    	height: 15px;
	    overflow: hidden;
    	text-overflow: clip;
    	margin-bottom: 10px;
	}
@media (min-width: 768px){
	.catalog .col-md-2{
		max-width: 12.5%;
		flex: 0 0 12.5%;
		padding-right: 3px;
		padding-left: 3px;
	}
}
@media (max-width: 575.98px){
	.prod-card{
		width: 80%;
		margin: 10px auto 0;
	}
	.prod-card .img-block{
		background-size: contain;
		height: 150px;
	}
	.prod-card p{
		height: 45px;
	}
}
@media (min-width: 576px) and (max-width: 767.98px) {
	.prod-card .img-block{
		background-size: contain;
		height: 150px;
	}
	.prod-card p{
		height: 45px;
	}
}
	
</style>
<h3>Ассортимент торговых автоматов</h3>
<div class="greyline1"></div>
<div class="info row assortt">
	<div class="col-md-4">
		<img src="img/automatikk.jpg" alt="">
	</div>
	<div class="col-md-8 flex align-items-center justify-content-center">
		<div>
			<h4>Торговые автоматы находится на странице</h4>
			<a href="automat.php">refanparfum.lv/automat.php</a>
		</div>
	</div>
</div>
<div class="row">
	<?php if ($query) {
		foreach ($query as $v) { ?>
	<div class="col-md-2 col-sm-6">
		<!-- onclick="location.href='http://parfumanalog.ru/tovar.php?refan=<?php echo $v['refan'] ?>'" -->
		<div class="prod-card">
			<div class="img-block" style="background-image: url(assort/<?php echo $v['img_url']; ?>);">
				<div class="prod-num">
					<span>Ячейка</span>
					<span class="num-wrap">№ <span class="num"><?php echo $v['cell']; ?></span></span>
				</div>	
				<div class="volume-num">
					<span><?php echo $v['volume']; ?>ML</span>
				</div>
			</div>
			<p class="pname"><?php echo $v['name']; ?></p>
			<p class="prefan">(Refan <?php echo $v['refan']; ?>)</p>
		</div>
	</div>
	<?php }}else{ ?>
		<div class="col-md-12">
			<h5 class="text-center mt-5">Ничего не найдено</h5>
		</div>
	<?php } ?>	
</div>
<?php include 'footer.php'; ?>