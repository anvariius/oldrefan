<?php
include '../bt/pdo.php';
include 'header.php';
$query = query("SELECT * FROM zakaz ORDER BY data DESC LIMIT 50");
?>
<style>
	.jumbotron{
		padding: 20px 10px;
	}
	.display-4{
		font-size: 40px;
	}
	h5.display-4{
		font-size: 30px;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<h3 class="text-center">Последние заказы</h3>
			<hr>
			<?php foreach($query as $v){ ?>
			<div class="jumbotron jumbotron-fluid">
			  	<div class="container">
			    	<h1 class="display-4">Заказ №<?php echo $v['id']; ?></h1>
			    	<h5 class="display-4">Дата заказа: <?php echo $v['data']; ?></h5>
			    	<p class="lead"><?php echo $v['zakaz']; ?></p>
			  	</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
include 'footer.php';
?>