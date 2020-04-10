<?php 
include '../bt/pdo.php';
include 'header.php';
$query = sequery("SELECT * FROM kosmetica WHERE status != 0");
?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<a href="main.php" class="btn btn-primary">Назад</a>
		</div>
		<div class="col-md-6"><h2 class="text-center mb-5">Разделы косметики</h2></div>
		</div>
</div>
<div class="container">
	<div class="row">
		<?php foreach ($query as $v) {?>
		<div class="col-md-6">
			<form action="engine2.php" method="POST" class="jumbotron">
				<h4 class="mb-4">Раздел #<?php echo $v['id'] ?></h4>
				<input type="hidden" name="token" value="<?php echo $token2 ?>">
				<input type="hidden" name="action" value="edit-kosmetic">
				<input type="hidden" name="id" value="<?php echo $v['id'] ?>">
				<input type="text" class="form-control mb-3 input-lg" name="name" required="" placeholder="Название раздела" value="<?php echo $v['name'] ?>">
				<textarea name="descr" cols="30" rows="10" class="form-control" placeholder="Описание раздела"><?php echo $v['descr'] ?></textarea>
				<hr class="my-4">
				<p class="lead">
				<button class="btn btn-primary btn-lg btn-block" type="submit">Сохранить</button>
				</p>
			</form>
		</div>
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>