<?php 
	include 'bt/pdo.php';
	ini_set('session.gc_maxlifetime', 0);
	ini_set('session.cookie_lifetime', 0);
	session_set_cookie_params(0); 
	session_start();
	if(!isset($_SESSION['basket'])) { //если не существует элемента массива 'basket'
		$_SESSION['basket'] = array(); // то нужно его создать
	}

	function getGender($value)
	{
		if ($value == '1') {
			return 'Men';
		}
		elseif($value == '0'){
			return 'Women';
		}
		else{
			return '';
		}

	}
	//print_r($_SESSION['basket']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<title>RefanParfum - Болгарский Парфюм.Ароматы мировых брендов.Доставка по всей Латвии.</title>
  	<link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/font-awesome.min.css">
  	<link rel="icon" href="img/favicon.ico">
  	<script src="js/jquery-3.0.0.min.js" charset="utf-8"></script>
  	<script src="js/bootstrap.min.js" charset="utf-8"></script>
  	<script src="js/jquery.maskedinput.min.js" charset="utf-8"></script>
  	<script src="js/popper.min.js" charset="utf-8"></script>
  	<script src="https://www.omniva.lv/widget/widget.js"></script>
  	<script src="https://www.omniva.ee/widget/widget.js"></script>
  	<script src="https://www.omniva.lt/widget/widget.js"></script>
  	<script src="js/jquery.cookie.js"></script>
	<script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>
	<script src="js/google-translate.js"></script>

	<!-- Global site tag (gtag.js) - Google Ads: 706639266 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-706639266"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'AW-706639266');
	</script>

	<!-- Event snippet for Заказ в 1 клик conversion page
	In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
	<script>
	function gtag_report_conversion(url) {
	  var callback = function () {
	    if (typeof(url) != 'undefined') {
	      window.location = url;
	    }
	  };
	  gtag('event', 'conversion', {
	      'send_to': 'AW-706639266/JIFsCMTHmbIBEKLr-dAC',
	      'transaction_id': '',
	      'event_callback': callback
	  });
	  return false;
	}
	</script>

	<!-- Event snippet for Покупка обычная conversion page
	In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
	<script>
	function gtag_report_conversion1(url) {
	  var callback = function () {
	    if (typeof(url) != 'undefined') {
	      window.location = url;
	    }
	  };
	  gtag('event', 'conversion', {
	      'send_to': 'AW-706639266/t0uMCMnPmbIBEKLr-dAC',
	      'transaction_id': '',
	      'event_callback': callback
	  });
	  return false;
	}
	</script>

	<!-- Event snippet for Консультация conversion page
	In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
	<script>
	function gtag_report_conversion2(url) {
	  var callback = function () {
	    if (typeof(url) != 'undefined') {
	      window.location = url;
	    }
	  };
	  gtag('event', 'conversion', {
	      'send_to': 'AW-706639266/NN35CLnBk7IBEKLr-dAC',
	      'event_callback': callback
	  });
	  return false;
	}
	</script>

	<!-- Event snippet for Подписка conversion page
	In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
	<script>
	function gtag_report_conversion3(url) {
	  var callback = function () {
	    if (typeof(url) != 'undefined') {
	      window.location = url;
	    }
	  };
	  gtag('event', 'conversion', {
	      'send_to': 'AW-706639266/h2BLCJG8h7IBEKLr-dAC',
	      'event_callback': callback
	  });
	  return false;
	}
	</script>
	<style>
		* {
		  -webkit-touch-callout: none;
			-webkit-user-select: none;
			 -khtml-user-select: none;
			   -moz-user-select: none;
				-ms-user-select: none;
					user-select: none;
		}
		#yt-widget .yt-servicelink{
			display: none !important;
		}
		#yt-widget .yt-listbox__cell{

		}
	</style>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
	   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	   ym(56257366, "init", {
	        clickmap:true,
	        trackLinks:true,
	        accurateTrackBounce:true
	   });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/56257366" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->


	<style>
		body {
		    margin: 0;
		    padding: 0;
		    /* margin-top: -30px; */
		}

		.page {
		    display: flex;
		    min-height: 100vh;
		}

		/* Фиксируем позицию body, которую меняет панель гугла*/

		body {
		    top: 0 !important;
		    position: static !important;
		    overflow-x: hidden;
		}

		/* Прячем панель гугла */

		.skiptranslate {
		    display: none !important;
		}

		/* language */

		.language {
		    /*position: fixed;
		    left: 10px;
		    top: 50%;
		    transform: translateY(-50%);
		    display: flex;
		    flex-direction: column;*/
		    display: flex;
		    justify-content: space-between;
		}

		.language__img {
		    margin: 2px;
		    cursor: pointer;
		    opacity: .5;
		}

		.language__img:hover,
		.language__img_active {
		    opacity: 1;
		}

		/* content */

		.content {
		    text-align: center;
		    margin: auto;
		}
	</style>


</head>
<body oncopy="return false;"> <!--    -->
	<!--Start of Tawk.to Script--> 
	<script type="text/javascript"> 
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date(); 
	(function(){ 
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0]; 
	s1.async=true; 
	s1.src='https://embed.tawk.to/5d25dd8f7a48df6da243de7a/default'; 
	s1.charset='UTF-8'; 
	s1.setAttribute('crossorigin','*'); 
	s0.parentNode.insertBefore(s1,s0); 
	})(); 
	</script> 
	 
	<!--End of Tawk.to Script-->
	<div class="alert alert-danger alert-dismissible" id="subs-alert" role="alert" style="margin-top: 587px;">
	    <strong>Ваша подписка оформлена!</strong>
	    <button type="button" class="close">
	      <span aria-hidden="true">×</span>
	    </button>
  	</div>
	<div class="modal-wrapper">
		<div class="okno modal-search">
			<div id="search" class="input-group">
	        	<input type="text" name="search" placeholder="Поиск" class="form-control input-lg search-query">
	        	<span class="input-group-addon">
	          		<button type="button" class="btn btn-default btn-lg search-button" onclick="toPage('search.php?query='+$('.search-query').val());"><i class="fa fa-search"></i></button>
	        	</span>
      		</div>
		</div>
		<div class="okno zakaz">
			<div class="modal-head">
				<img src="img/logo.png" alt="">
			</div>
			<div class="modal-content">
				<h3>Благодарим за заказ</h3>
				<div class="greyline"></div>
				<p>Наш менеджер свяжется с вами в ближайшее время<br>для подтверждения заказа</p>
				<div class="links">
					<a href="mailto:info@refanparfum.lv"><i class="fa fa-envelope-o" aria-hidden="true"></i>info@refanparfum.lv</a>
					<a href="tel:+37129552156"><i class="fa fa-phone" aria-hidden="true"></i>+371 2955 2156</a>
				</div>
				<div class="subs">
				  	<label class="">
				    	Подписаться на рассылку обновлений
				  	</label>
				  	<input class="" type="checkbox" checked>
				</div>
				<div class="buttons">
					<button class="close-popup">закрыть</button>
				</div>
			</div>
		</div>
		<div class="okno spasibo">
			<div class="modal-head">
				<img src="img/logo.png" alt="">
			</div>
			<div class="modal-content">
				<h3>Благодарим за обращение</h3>
				<div class="greyline"></div>
				<p>Наш менеджер свяжется с вами в ближайшее время<br>для проведения консультации</p>
				<div class="links">
					<a href="mailto:info@refanparfum.lv"><i class="fa fa-envelope-o" aria-hidden="true"></i>info@refanparfum.lv</a>
					<a href="tel:+37129552156"><i class="fa fa-phone" aria-hidden="true"></i>+371 2955 2156</a>
				</div>
				<div class="buttons">
					<button class="close-popup">закрыть</button>
				</div>
			</div>
		</div>
		<div class="okno consult">
			<div class="modal-head">
				<img src="img/logo.png" alt="">
			</div>
			<div class="modal-content">
				<h3>заказать консультацию</h3>
				<div class="greyline"></div>
				<form action="">
					<div class="form-group row">
					    <label for="inputEmail3" class="col-sm-4 col-form-label">ИМЯ</label>
					    <div class="col-sm-8">
					      	<input type="text" class="form-control user-name" placeholder="ИМЯ">
					    </div>
				  	</div>
				  	<div class="form-group row">
				    	<label for="inputPassword3" class="col-sm-4 col-form-label">номер телефона</label>
				    	<div class="col-sm-8">
					      	<input type="text" class="form-control user-phone" placeholder="номер телефона">
				    	</div>
				  	</div>
				</form>
				<div class="buttons">
					<button class="close-popup white">назад</button>
					<button class="consult-zakaz" onclick="gtag_report_conversion2()">заказать</button>
				</div>
			</div>
		</div>
		<div class="okno one-click">
			<div class="modal-head">
				<img src="img/logo.png" alt="">
			</div>
			<div class="modal-content">
				<h3>купить в 1 клик</h3>
				<div class="greyline"></div>
				<form action="">
					<div class="form-group row">
					    <label for="inputEmail3" class="col-sm-4 col-form-label">ИМЯ</label>
					    <div class="col-sm-8">
					      	<input type="text" class="form-control user-name" placeholder="ИМЯ">
					    </div>
				  	</div>
				  	<div class="form-group row">
				    	<label for="inputPassword3" class="col-sm-4 col-form-label">номер телефона</label>
				    	<div class="col-sm-8">
					      	<input type="text" class="form-control user-phone" placeholder="номер телефона">
				    	</div>
				  	</div>
				  	<div class="form-group row">
				    	<label for="inputPassword3" class="col-sm-4 col-form-label">Email</label>
				    	<div class="col-sm-8">
					      	<input type="text" class="form-control user-email" placeholder="Email">
				    	</div>
				  	</div>
				  	<!--
				  	<div class="form-group row">
				    	<label for="inputPassword3" class="col-sm-4 col-form-label">промокод</label>
				    	<div class="col-sm-5">
					      	<input type="text" class="form-control" placeholder="промокод">
				    	</div>
				    	<div class="col-sm-3">
				    		<button class="">применить</button>
				    	</div>
				  	</div>
					-->
				  	<div class="citycheckk form-group row mt-3">
		      			<label class="col-sm-4 col-form-label">Выберите страну</label>
		      			<div class="col-sm-8">
		      				<select>
			      				<option value="LV">Латвия</option>
			      				<option value="EE">Эстония</option>
			      				<option value="LT">Литва</option>
			      			</select>
		      			</div>		      			
		      		</div>
				  	<div class="form-group row sposob-dostavki">
				  		<label for="inputPassword3" class="col-sm-4 col-form-label">Способ доставки</label>
				  		<div class="col-sm-8">
				  			<div class="form-check">
				        		<input class="form-check-input kuriyer" checked="" type="checkbox" id="gridCheck1">
				        		<label class="form-check-label" for="gridCheck1">
				          			Курьерская доставка - <b class="summa-dostavki">10</b> € 
				        		</label>
				      		</div>
				      		<div class="form-check">
				        		<input class="form-check-input freeship" type="checkbox" id="gridCheck1">
				        		<label class="form-check-label" for="gridCheck1">Пакомат Omniva - <b class="ppaakkoo">3 €</b><img src="img/omniva-mini.png" alt="" class="mini-icon"></label>
				      		</div>
				  		</div>
				  	</div>
				  	<div class="form-group row pakomatto" style="display: none;">
				  		<label for="inputPassword3" class="col-sm-4 col-form-label">Выберите удобный почтомат</label>
				  		<div class="col-sm-8">
				  			<div id="omniva_container2"></div>
				  			<script>
								var wd2 = new OmnivaWidget({

								    compact_mode: true,

								    show_offices: false,

								    custom_html: false,

								    id: 2,

								    selection_value: '',

								    country_id: $('.citycheckk select').val(),
								});
							</script>
				  		</div>
				  	</div>
				  	<div class="form-group row adrr">
				  		<label for="inputPassword3" class="col-sm-4 col-form-label">Введите ваш адрес</label>
				  		<div class="col-md-8">
				  			<input class="adrs" type="text">
				  		</div>
				  	</div>
				  	<div class="form-group row sposob-oplaty">
				  		<label for="inputPassword3" class="col-sm-4 col-form-label">Способ оплаты</label>
				  		<div class="col-sm-8">
				      		<div class="form-check kuriyerinho">
				        		<input class="form-check-input" type="checkbox" id="gridCheck1">
				        		<label class="form-check-label text-left" for="gridCheck1">
				          			Оплата картой курьеру при получении
				        		</label>
				      		</div>
				      		<div class="form-check pakomatinho" style="display: none;">
				        		<input class="form-check-input" type="checkbox" id="gridCheck2">
				        		<label class="form-check-label text-left" for="gridCheck1">
				          			Оплата картой в пакомате Omniva при получении
				        		</label>
				      		</div>
				      		<div class="form-check">
				        		<input class="form-check-input bankshit" type="checkbox" id="gridCheck3" checked="">
				        		<label class="form-check-label text-left" for="gridCheck1">
				          			Перевод на банковский счет
				        		</label>
				      		</div>
				    	</div>
				  	</div>
				</form>
				<h5>СУММА ЗАКАЗА <span>40</span>€</h5>
				<div class="buttons">
					<button class="close-popup white">назад</button>
					<button class="oneclick-button" onclick="gtag_report_conversion()">заказать</button>
				</div>
				<div class="row">
					<div class="col-md-10 offset-md-1">
						<span class="politica text-muted">Оформив заказ, вы соглашаетесь с <a href="pravila.php">правилами пользования</a> и <a href="politica.php">политикой конфиденциальности</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sidebar-opacity"></div>
	<div class="sidebar information">
		<ul>
			<li class="sidebar-title"><a href="">ИНФОРМАЦИЯ</a><span class="close-sidebar" aria-hidden="true">×</span></li>
			<div class="mobile">
				<li><a href="index.php">Главная</a></li>
				<li><a href="catalog.php?category=woman">Женщинам</a></li>
				<li><a href="catalog.php?category=man">Мужчинам</a></li>
				<li><a href="catalog.php">Аксессуары</a></li>
				<li><a href="catalog.php?category=brands">Бренды</a></li>
				<li><a href="automat.php">ТОРГОВЫЕ АВТОМАТЫ</a></li>
				<li><a href="feedback.php">Отзывы</a></li>
				<li><a href="catalog.php?category=nabor">Парфюмерные наборы</a></li>
			</div>
			<li><a href="about.php">О НАС</a></li>
			<li><a href="dostavka.php">ИНФОРМАЦИЯ О ДОСТАВКЕ</a></li>
			<li><a href="oplata.php">ИНФОРМАЦИЯ ОБ ОПЛАТЕ</a></li>
			<li><a href="garanty.php">ГАРАНТИЯ</a></li>
			<li><a href="" class="open-contacts">КОНТАКТЫ</a></li>
			<li><a href="pravila.php">Правила пользования</a></li>
			<li><a href="vozvrat.php">Возврат</a></li>
			<li><a href="politica.php">Конфиденциальность</a></li>
		</ul>
	</div>
	<div class="sidebar contacts">
		<ul>
			<li class="sidebar-title"><a href="">Контакты</a><span class="close-sidebar" aria-hidden="true">×</span></li>
			<li><h4>Адрес<img src="img/location.png" alt=""></h4><a href="">Rīga, Aleksandra Čaka ielā 33</a></li>
			<li><h4>ТЕЛЕФОН</h4><a href="tel:+37129552156">+371 2955 2156</a></li>
			<li><h4>ВРЕМЯ РАБОТЫ</h4><a href="">С пОНЕДЕЛЬНИКА по пЯТНИЦУ<br>с 9:00 до 19:00<br>*Заявки на сайте принимаются круглосуточно</a></li>
			<button class="zakaz-consult" onclick="openModal('.consult')">ЗАКАЗАТЬ КОНСУЛЬТАЦИЮ</button>
		</ul>
	</div>
	<section class="hat">
		<div class="wrap">
			<ul>
				<li><a href="#" onclick="toPage('basket.php');">моя корзина</a></li>
				<li><a href="#" onclick="toPage('pokupka.php');">оформить покупку</a></li>
				<li><a href="#" onclick="openModal('.consult')">консультация</a></li>
				<li><a href="tel:+37129552156"><i class="fa fa-phone" aria-hidden="true"></i>+371 2955 2156</a></li>
				<li><a href="mailto:info@refanparfum.lv"><i class="fa fa-envelope" aria-hidden="true"></i>info@refanparfum.lv</a></li>
				<!-- <li class="translated"><div id="ytWidget"></div><script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=ru&widgetTheme=dark&autoMode=true" type="text/javascript"></script></li> -->
				<!-- <li class="translated">
					
					<a href="#" onclick="doGTranslate('ru|en');return false;" title="English" class="gflag nturl" style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png" height="32" width="32" alt="English" /></a><a href="#" onclick="doGTranslate('ru|ru');return false;" title="Russian" class="gflag nturl" style="background-position:-500px -200px;"><img src="//gtranslate.net/flags/blank.png" height="32" width="32" alt="Russian" /></a><a href="#" onclick="doGTranslate('ru|lv');return false;" title="Latvian" class="gflag nturl" style="background-position:-400px -300px;"><img src="//gtranslate.net/flags/blank.png" height="32" width="32" alt="Latvian" /></a>
				
					<style type="text/css">
					a.gflag {vertical-align:middle;font-size:32px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/32.png);}
					a.gflag img {border:0;}
					a.gflag:hover {background-image:url(//gtranslate.net/flags/32a.png);}
					</style>
				
				
				
					<script type="text/javascript">
					/* <![CDATA[ */
					function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='ru';if(lang == 'ru')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;}
					/* ]]> */
					</script>
				</li> -->
				<li class="translated">
					<div class="language">
				        <img src="img/002-russia.png" alt="ru" data-google-lang="ru" class="language__img">
				        <img src="img/001-united-kingdom.png" alt="en" data-google-lang="en" class="language__img">
				        <img src="img/004-latvia.png" alt="lv" data-google-lang="lv" class="language__img">
				        <img src="img/005-estonia.png" alt="eu" data-google-lang="eu" class="language__img">
				        <img src="img/003-lithuania.png" alt="lt" data-google-lang="lt" class="language__img">
				        <img src="img/germany.png" alt="de" data-google-lang="de" class="language__img">
				    </div>
				</li>
			</ul>
		</div>
	</section>
	<header>
		<div class="wrap">
			<div class="row">
				<div class="col-12 mobile">
					<img src="img/logo.png" class="logo" alt="">
				</div>
				<div class="col-lg-1 col-3 col-md-2 icon-block">
					<a href="" class="open-info">
						<div class="img-wrap"><img src="img/info-icon.png" alt=""></div>
						<span>информация</span>
					</a>
				</div>	
				<div class="col-lg-1 col-3 col-md-2 icon-block">
					<a href="" class="open-contacts">
						<div class="img-wrap"><img src="img/contact-icon.png" alt="" class="contact-icon"></div>
						<span>контакты</span>
					</a>
				</div>
				<div class="col-lg-4 offset-lg-2 col-md-4 full">
					<a href="index.php"><img src="img/logo.png" class="logo" alt=""></a>
				</div>
				<div class="col-lg-1 offset-lg-2 col-3 col-md-2 icon-block">
					<a href="basket.php" class="open-basket">
						<div class="img-wrap"><b class="numofbasket"><?php echo count($_SESSION['basket']); ?></b></div>
						<span>корзина</span>
					</a>
				</div>	
				<div class="col-lg-1 col-3 col-md-2 icon-block">	
					<a href="" class="open-search">
						<div class="img-wrap"><img src="img/search-icon.png" alt=""></div>
						<span>поиск</span>
					</a>
				</div>
			</div>
		</div>
	</header>
	<div class="line-opacity"></div>
	<nav class="full">
		<ul class="nav">
			<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Главная</a></li>
			<li><a href="catalog.php?category=woman">Женщинам</a></li>
			<li><a href="catalog.php?category=man">Мужчинам</a></li>
			<li><a href="catalog.php?category=accs">Аксессуары</a></li>
			<li><a href="catalog.php?category=brands">Бренды</a></li>
			<li><a href="automat.php">ТОРГОВЫЕ АВТОМАТЫ</a></li>
			<li><a href="feedback.php">Отзывы</a></li>
			<li><a href="catalog.php?category=nabor" class="podsvetka">Парфюмерные наборы</a></li>
		</ul>
	</nav>
	<section class="sale-line">
		<h3><span>специальное предложение!</span> бесплатная доставка в пакоматы omniva при заказе от 30€ по Латвии! <span>От 50€ по Литве и Эстонии!</span> Доставка по прибалтике в течении 2х рабочих дней!<br><a href="https://parfumanalog.ru" target="blank">www.parfumanalog.ru</a></h3>
	</section>
	<main>
		<div class="container">
			<div class="catalog">