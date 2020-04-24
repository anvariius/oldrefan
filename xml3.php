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
		<?php if ($v['intensive'] == 4) { ?>
		<name><?php echo $v['name']; ?></name><br>
		<?php }else{ ?>
		<name>REFAN <?php echo $v['refan']; ?></name><br>
		<?php } ?>
		<link>https://refanparfum.lv/tovar.php?product-id=<?php echo $v['id']; ?></link><br>
		<price><?php echo $v['price']; ?></price><br>
		<image>https://refanparfum.lv/catalog/<?php echo $v['img_url']; ?></image><br>
		<?php if ($v['intensive'] == 4) { ?>
			<category_full>Skaistums un veselība > Косметика</category_full><br>
		<?php }else{ ?>	
		<category_full>Skaistums un veselība > Parfimērija > <?php if($v['gender']=='0'){echo "Sieviešu smaržas";}else{echo "Vīriešu smaržas";} ?></category_full><br>
		<?php } ?>
		<?php if ($v['intensive'] == 4) { ?>
			<category_link>https://www.refanparfum.lv/kosmetica.php</category_link><br>
		<?php }else{ ?>	
			<category_link>https://www.refanparfum.lv/catalog.php?category=<?php if($v['gender']=='0'){echo "woman";}else{echo "man";} ?></category_link><br>
		<?php } ?>
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