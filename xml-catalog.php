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
	  <name><?php echo $v['name']; ?></name><br>
	  <link>https://refanparfum.lv/tovar.php?product-id=<?php echo $v['id']; ?></link><br>
	  <price><?php echo $v['price']; ?></price><br>
	  <image>https://refanparfum.lv/catalog/<?php echo $v['img_url']; ?></image><br>
	  <manufacturer><?php echo getBrand($v['brand']); ?></manufacturer><br>
	  <category><?php echo getCategory($v['intensive']); ?></category><br>
	  <category_full><?php echo getFullCategory($v['gender'], $v['intensive']); ?></category_full><br>
	</item>
	<br>
	<br>
	<?php } ?>
	</root>
	</xml>
</body>
</html>