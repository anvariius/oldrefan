<?php
include '../bt/pdo.php';
include 'header.php';

if (!isset($_COOKIE['sorting'])) {
	$sort_title = "Сегодня";
	$sortquery = "DATE(data) = DATE(CURRENT_DATE)";
}
switch ($_COOKIE['sorting']) {
		case '1':
			$sort_title = "Сегодня";
			$sortquery = "DATE(data) = DATE(NOW())";
			break;
		case '2':
			$sort_title = "Вчера";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 1 DAY) AND data<(CURRENT_DATE)";
			break;
		case '3':
			$sort_title = "2 дня назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 2 DAY) AND data<(CURRENT_DATE - INTERVAL 1 DAY)";
			break;	
		case '4':
			$sort_title = "3 дня назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 3 DAY) AND data<(CURRENT_DATE - INTERVAL 2 DAY)";
			break;	
		case '5':
			$sort_title = "4 дня назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 4 DAY) AND data<(CURRENT_DATE - INTERVAL 3 DAY)";
			break;
		case '6':
			$sort_title = "5 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 5 DAY) AND data<(CURRENT_DATE - INTERVAL 4 DAY)";
			break;	
		case '7':
			$sort_title = "6-10 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 10 DAY) AND data<(CURRENT_DATE - INTERVAL 5 DAY)";
			break;
		case '8':
			$sort_title = "11-15 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 15 DAY) AND data<(CURRENT_DATE - INTERVAL 10 DAY)";
			break;	
		case '9':
			$sort_title = "16-20 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 20 DAY) AND data<(CURRENT_DATE - INTERVAL 15 DAY)";
			break;
		case '10':
			$sort_title = "21-25 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 25 DAY) AND data<(CURRENT_DATE - INTERVAL 20 DAY)";
			break;
		case '11':
			$sort_title = "26-29 дней назад";
			$sortquery = "data>(CURRENT_DATE - INTERVAL 29 DAY) AND data<(CURRENT_DATE - INTERVAL 25 DAY)";
			break;							
		default:
			# code...
			break;
	}
$query = sequery("SELECT * FROM zakaz WHERE ".$sortquery." AND status!=0 ORDER BY data DESC");
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
				<div class="row">
					<div class="col-md-4">
						<h3 class="mb-0">Заказы</h3>
					</div>
					<div class="col-md-4 offset-md-4">
						<div class="dropdown sorting">
							<button class="btn btn-outline-dark dropdown-toggle btn-block" type="button" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $sort_title ?></button>
							<div class="dropdown-menu" aria-labelledby="dropdown2">
								<a href="1" class="dropdown-item">Сегодня</a>
								<a href="2" class="dropdown-item">Вчера</a>
								<a href="3" class="dropdown-item">2 дня назад</a>
								<a href="4" class="dropdown-item">3 дня назад</a>
								<a href="5" class="dropdown-item">4 дня назад</a>
								<a href="6" class="dropdown-item">5 дней назад</a>
								<a href="7" class="dropdown-item">6-10 дней назад</a>
								<a href="8" class="dropdown-item">11-15 дней назад</a>
								<a href="9" class="dropdown-item">16-20 дней назад</a>
								<a href="10" class="dropdown-item">21-25 дней назад</a>
								<a href="11" class="dropdown-item">26-30 дней назад</a>
							</div>
						</div>
					</div>
				</div>
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
<script>
	$('.sorting a').click(function (e) {
		e.preventDefault();
		$.cookie('sorting',$(this).attr('href'));
		location.reload();
	});
</script>
<?php
include 'footer.php';
?>