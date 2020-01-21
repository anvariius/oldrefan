<?php 
include 'bt/pdo.php';

$query = sequery("SELECT * FROM catalog WHERE status != 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>XML-catalog</title>
</head>
<body>
	
	<xml version='1.0' encoding='utf-8'>
	<root>
	<?php foreach ($query as $v) { ?>
	<item>
		<name>REFAN <?php echo $v['refan']; ?></name><br>
		<link>https://refanparfum.lv/tovar.php?product-id=<?php echo $v['id']; ?></link><br>
		<price><?php echo $v['price']; ?></price><br>
		<image>https://refanparfum.lv/catalog/<?php echo $v['img_url']; ?></image><br>
		<category_full>Skaistums un veselība > <?php if($v['gender']=='0'){echo "Sieviešu smaržas";}else{echo "Vīriešu smaržas";} ?></category_full><br>
		<category_link>https://www.refanparfum.lv/catalog.php?category=<?php if($v['gender']=='0'){echo "woman";}else{echo "man";} ?></category_link><br>
		<brand>Refan</brand><br>
		<delivery_omniva>3.00</delivery_omniva><br>
		<delivery_days_latvija>2</delivery_days_latvija><br>
	</item>
	<br>
	<br>
	<?php } ?>
	</root>
	</xml>
</body>
</html>