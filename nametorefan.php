<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include 'bt/pdo.php';
$query = sequery("SELECT * FROM catalog");
foreach ($query as $v) {
	$v['name'] = trim($v['name']);
	$refan = substr($v['name'],-4,3);
	$id = $v['id'];
	$a = query("UPDATE catalog SET refan=:refan WHERE id=:id", compact('refan','id'));
}
?>