<?php
if (!isset($_COOKIE['auth']) || $_COOKIE['auth'] != 'acrqc9') {
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель управления</title>
	<link rel="stylesheet" href="../css/style.css">
  	<link rel="stylesheet" href="../css/bootstrap.min.css">
  	<link rel="stylesheet" href="../css/font-awesome.min.css">
  	<script src="../js/jquery-3.0.0.min.js" charset="utf-8"></script>
  	<script src="../js/popper.min.js" charset="utf-8"></script>
  	<script src="../js/bootstrap.min.js" charset="utf-8"></script>
  	<script src="../js/popper.min.js" charset="utf-8"></script>	
  	<style>
  		.card h5{
  			height: 20px;
  		}
  		.card .img-top{
  			background-size: 80%;
  			background-position: center;
  			width: 100%; 
  			height: 200px;
  			background-repeat: no-repeat;
  		}
  		.nav-pills a{
  			text-transform: capitalize;
  		}
  		.mailing-form{
  			width: 100%;
  		}
  		.mailing-form label{
  			font-size: 20px;
  		}
  		nav a{
		    font-size: 14px;
		    margin-right: 5px;
		    margin-left: 5px;
  		}
  		/*.container.wrapp{
  			max-width: 1240px;
  		}*/
  	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
	  	<div class="container-fluid">
	  		<a class="navbar-brand" href="main.php">REFANPARFUME</a>
		  	<div class="collapse navbar-collapse">
	    		<ul class="navbar-nav mr-auto">
	    			
		      		<li class="nav-item">
		        		<a class="nav-link" href="main.php">Главная</a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="emails.php">Рассылка</a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="automats.php">Автоматы</a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="assortiment.php">Ассортимент</a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="zakazy.php">Заказы</a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="feedback.php">Отзывы</a>
		      		</li>
		      		<!--
		      		<li class="nav-item">
		        		<a class="nav-link disabled" href="#">Disabled</a>
		      		</li>
		      		-->
		    	</ul>
		    	<form class="form-inline my-2 search-tovar">
		      		<input class="form-control mr-sm-2" type="search" placeholder="поиск по каталогу" aria-label="поиск по каталогу">
		      		<button class="btn btn-outline-success my-2" type="button">Поиск</button>
		    	</form>
		  	</div>
	  	</div>
	</nav>