<?php
include 'bt/pdo.php';
session_start();
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'addtobasket':
			array_push($_SESSION['basket'], $_POST['product_id']);
			$_SESSION['basket'] = array_unique($_SESSION['basket']);
			echo count($_SESSION['basket']);
			break;
		case 'removefrombasket':
			unset($_SESSION['basket'][array_search($_POST['product_id'],$_SESSION['basket'])]);
			break;
		case 'removeallfrombasket':
			$_SESSION['basket'] = array();
			$_SESSION['tovars'] = array();
			break;
		case 'setbasket':
			$_SESSION['tovars'] = json_decode($_POST['tovars'],true);
			break;	
		case 'sendzakaz':
			$summa_zakaza = 0;
			$user_name = $_POST['user_name'];
			$user_phone = $_POST['user_phone'];
			$user_email = $_POST['user_email'];
			$sposob_oplaty = $_POST['sposob_oplaty'];
			//echo $sposob_oplaty;
			$sposob_dostavki = $_SESSION['tovars']['dostavka'];
			$country = $_SESSION['tovars']['country'];
			if(isset($_SESSION['tovars']['pakomat'])){
				$pakomat = $_SESSION['tovars']['pakomat'];
				$adress = 'none';
			}
			else{
				$pakomat = "Не выбран";
				$adress = $_SESSION['tovars']['adrs'];
			}

			unset($_SESSION['tovars']['dostavka']);
			unset($_SESSION['tovars']['pakomat']);
			unset($_SESSION['tovars']['adrs']);
			unset($_SESSION['tovars']['country']);

			$message = 'Jūsu pasūtījums ir pieñemts. Tuvākajā laikā ar jums sazināsimies! Paldies par uzticību!';
			$zapros = '<p>Заказ парфюма</p></br><b>Имя: '.$user_name.'</b></br><b>Номер телеофна: '.$user_phone.'</b></br><b>Email: '.$user_email.'</b></br><b>Товары:</b></br>';

			foreach ($_SESSION['tovars'] as $key => $value) {
				$query = sequery("SELECT name,price FROM catalog WHERE id = $key");
				$zapros .= '<b>'.$query['name'].'('.$value.' шт)</b></br>';
				$summa_zakaza += $query['price']*$value;


				$ip = $_SERVER['REMOTE_ADDR'];
				$action = 1;
				$product_id = $key;
				$pokupka = query("INSERT INTO actions (action, product_id, ip) VALUES (:action, :product_id, :ip)", compact('action', 'product_id', 'ip'));
			}
			if ($country == "LV") {
				if ($sposob_dostavki == 'курьер') {
					$summa_zakaza += 10;
				}
				else{
					if ($summa_zakaza<30) {
						$summa_zakaza += 3;
					}
				}
			}
			else{
				if ($sposob_dostavki == 'курьер') {
					$summa_zakaza += 10;
				}
				else{
					if ($summa_zakaza<50) {
						$summa_zakaza += 6;
					}
				}
			}
			$zapros .= '<b>Страна: '.$country.'</b></br>';
			$zapros .= '<b>Сумма заказа: '.$summa_zakaza.'€</b></br>';
			$zapros .= '<b>Способ оплаты: '.$sposob_oplaty.'</b></br>';
			$zapros .= '<b>Способ доставки: '.$sposob_dostavki.'</b></br>';
			$zapros .= '<b>Адрес: '.$adress.'</b></br>';
			$zapros .= '<b>Пакомат: '.$pakomat.'</b></br>';
			$_SESSION['basket'] = array();
			$_SESSION['tovars'] = array();
			echo $zapros;

			$to  = "<".$_POST['user_email'].">";//почта админа
			$subject = "RefanParfum.lv"; 
			$headers  = "Content-type: text/html; charset=utf8 \r\n"; 
			$headers .= "From: От кого письмо <info@refanparfum.lv>\r\n";  
			$msgg = '<b>Спасибо за заявку! Ваш заказ был принят! Наш консультант вскоре свяжется с вами!</b>';
			$pokupka = query("INSERT INTO zakaz (zakaz) VALUES (:zapros)", compact('zapros'));
			mail($to, $subject, $msgg, $headers);
			echo $to;

			break;
		case 'addEmail':
			$user_email = $_POST['user_email'];
			$user_phone = $_POST['user_phone'];
			$query = sequery("SELECT * FROM emails WHERE email =:user_email AND status = 1 LIMIT 1",compact("user_email"));
			if (count($query) == 0) {
				$query = query("INSERT INTO emails (email, phone) VALUES (:user_email, :user_phone)",
					compact('user_email', 'user_phone'));
			}
			elseif ($query['phone']=='') {
				$id = $query['id'];
				$query = query("UPDATE emails SET phone = :user_phone WHERE id = :id LIMIT 1", compact('user_phone', 'id'));
			}
			break;	
		case 'buyoneclick':
			$user_name = $_POST['user_name'];
			$user_phone = $_POST['user_phone'];
			$product_id = $_POST['product_id'];
			$user_email = $_POST['user_email'];
			$country = $_POST['country'];
			$summa_zakaz = $_POST['summa_zakaz'];	
			$summa_zakaz = (int)$summa_zakaz;
			$sposob_oplaty = $_POST['sposob_oplaty'];
			$sposob_dostavki = $_POST['sposob_dostavki'];
			$pakomat = $_POST['pakomat'];
			if ($sposob_dostavki == 'курьер') {
				//$summa_zakaz +=10;
				$adrs = $_POST['adrs'];
				$pakomat = 'none';
			}
			else{
				//$summa_zakaz +=3;
				$adrs = 'none';
				$pakomat = $_POST['pakomat'];
			}
			
			$query = sequery("SELECT name,price FROM catalog WHERE id = $product_id");
			$message = 'Jūsu pasūtījums ir pieñemts. Tuvākajā laikā ar jums sazināsimies! Paldies par uzticību!';
			$zapros = '<p>Заказ парфюма в один клик</p></br><b>Имя: '.$user_name.'</b></br><b>Номер телеофна: '.$user_phone.'</b></br>';
			$zapros .= '<b>Товар: '.$query['name'].'</b></br>';
			$zapros .= '<b>Страна: '.$country.'</b></br>';
			$zapros .= '<b>Сумма заказа: '.$summa_zakaz.'€</b></br>';
			$zapros .= '<b>Способ оплаты: '.$sposob_oplaty.'</b></br>';
			$zapros .= '<b>Способ доставки: '.$sposob_dostavki.'</b></br>';
			$zapros .= '<b>Пакомат: '.$pakomat.'</b></br>';
			$zapros .= '<b>Адрес: '.$adrs.'</b></br>';
			echo $zapros;

			$to  = "<".$_POST['user_email'].">";//почта админа
			$subject = "RefanParfum.lv"; 
			$headers  = "Content-type: text/html; charset=utf8 \r\n"; 
			$headers .= "From: От кого письмо <info@refanparfum.lv>\r\n";
			$msgg = '<b>Спасибо за заявку! Ваш заказ был принят! Наш консультант вскоре свяжется с вами!</b>';
			$pokupka = query("INSERT INTO zakaz (zakaz) VALUES (:zapros)", compact('zapros'));
			mail($to, $subject, $msgg, $headers);

			$ip = $_SERVER['REMOTE_ADDR'];
			$action = 1;
			$pokupka = query("INSERT INTO actions (action, product_id, ip) VALUES (:action, :product_id, :ip)", compact('action', 'product_id', 'ip'));

			echo $to;
			break;
		case 'zakazconsult':
			$user_name = $_POST['user_name'];
			$user_phone = $_POST['user_phone'];
			$message = 'Jūsu pasūtījums ir pieñemts. Tuvākajā laikā ar jums sazināsimies! Paldies par uzticību!';
			$zapros = '<p>Заявка на консультацию</p></br><b>Имя: '.$user_name.'</b></br><b>Номер телеофна: '.$user_phone.'</b></br>';

			echo $zapros;
			break;
		case 'subscribe':
			$email = $_POST['user_email'];
			$zapros = '<p>Заявка на подписку</p></br><b>Email: '.$email.'</b>';
			$message = 'текст рассылки при подписке';
			//echo $zapros;
			$query = sequery("SELECT email FROM emails WHERE email =:email AND status = 1",compact("email"));
			if (count($query) == 0) {
				$query = query("INSERT INTO emails (email) VALUES (:email)",
					compact('email'));
			}
			$to  = "<info@refanparfum.lv>";//почта админа
			$subject = "Новый клиент"; 
			$headers  = "Content-type: text/html; charset=utf8 \r\n"; 
			$headers .= "From: От кого письмо <zakaz@mail.ru>\r\n";  
			//mail($to, $subject, $zapros, $headers);

			$token = '6775g37nuu6w9ujwe5obojou84jhdgtdr8krkpcy';
			$email = 'info@refanparfum.lv';
			$params = [
				'format' => 'json',
				'api_key' => $token,
				'email' => $email,
				'sender_name' => 'refanparfum',
				'sender_email' => 'info@refanparfum.lv',
				'subject' => $subject,
				'body' => $zapros,
				'list_id' => '19981550'
			];

			$get_params = http_build_query($params);
			$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));
			break;	
		case 'auth':
			if ($_POST['login'] != 'admin' && $_POST['password'] != 's6cWZ6xUyG') {
				echo 'invalid_form';
			}
			elseif ($_POST['login'] != 'admin') {
				echo 'invalid_login';
			}
			elseif ($_POST['password'] != 's6cWZ6xUyG') {
				echo 'invalid_password';
			}
			else{
				setcookie('auth', 's6cWZ6xUyG');
				echo 'valid_form';
			}
			break;	
		case 'add_feedback':
			if (isset($_POST['hehehe'])) {
				die();
			}
			if ($_POST['invis'] != '') {
				die();
			}
			$name = htmlspecialchars($_POST['name']);
			$email = htmlspecialchars($_POST['email']);
			$city = htmlspecialchars($_POST['city']);
			$tovar = htmlspecialchars($_POST['tovar']);
			$message = htmlspecialchars($_POST['message']);
			$img = $_FILES['img'];
			$query = query("INSERT INTO feedback (name, email, city, tovar, message) VALUES (:name, :email, :city, :tovar, :message)", compact('name', 'email', 'city', 'tovar', 'message'));
			$fb_id =  DB::getInstance()->lastInsertId();

			foreach ($img['error'] as $key => $value) {
				if ($value == 0) {
					$type = substr($img['type'][$key], 6);
					$img_url = md5("athletic_fb".$articul.$fb_id.$key).".".$type;
					move_uploaded_file($_FILES['img']['tmp_name'][$key], 'feedback/'.$img_url);
					$query = query("INSERT INTO fb_img (fb_id,img_url) VALUES (:fb_id,:img_url)", compact('fb_id','img_url'));
				}
			}

			header("Location: feedback.php?sended=true");
			break;	
		default:
			# code...
			break;
	}
}


if ($_POST['action'] == 'zakazconsult' || $_POST['action'] == 'sendzakaz' || $_POST['action'] == 'buyoneclick') {
 	$sUrl  = 'https://letsads.com/api';
    $sXML  = '<?xml version="1.0" encoding="UTF-8"?>
              <request>
                  <auth>
                      <login>37129727419</login>
                      <password>488158</password>
                  </auth>
                  <message>
                      <from>RefanParfum</from>
                      <text>'.$message.'</text>
                      <recipient>'.$_POST['user_phone'].'</recipient>
                  </message>
              </request>';
	$rCurl = curl_init($sUrl);
	curl_setopt($rCurl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($rCurl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($rCurl, CURLOPT_HEADER, 0);
	curl_setopt($rCurl, CURLOPT_POSTFIELDS, $sXML);
	curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($rCurl, CURLOPT_POST, 1);
	$sAnswer = curl_exec($rCurl);
	curl_close($rCurl);


	echo $sAnswer;

	$to  = "<info@refanparfum.lv>";//почта админа
	$subject = "Новый клиент"; 
	$headers  = "Content-type: text/html; charset=utf8 \r\n"; 
	$headers .= "From: От кого письмо <info@refanparfum.lv>\r\n";  
	//mail($to, $subject, $zapros, $headers);


	$token = '6775g37nuu6w9ujwe5obojou84jhdgtdr8krkpcy';
	$email = 'info@refanparfum.lv';
	$params = [
		'format' => 'json',
		'api_key' => $token,
		'email' => $email,
		'sender_name' => 'refanparfum',
		'sender_email' => 'info@refanparfum.lv',
		'subject' => $subject,
		'body' => $zapros,
		'list_id' => '19981550'
	];

	$get_params = http_build_query($params);
	$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));
	
} 

             
?>