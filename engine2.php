<?php
include '../bt/pdo.php';
function trim_value(&$value)
{
    $value = trim($value);
}
session_start();
if (isset($_POST['token']) && $_POST['token'] == $token2 && isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'remove_tovar':
			$id = $_POST['product_id'];
			$query = query("UPDATE catalog SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'restore_tovar':
			$id = $_POST['product_id'];
			$query = query("UPDATE catalog SET status = 1 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'editprod':
			$id = $_POST['id'];
			$razdel = $_POST['razdel'];
			$category = $_POST['category'];
			$gender = $_POST['gender'];
			$brand_id = $_POST['brand'];
			$season = $_POST['season'];;
			$articul = $_POST['articul'];
			$model = $_POST['model'];
			$size = $_POST['size'];
			$color = $_POST['color'];
			$old_price = $_POST['old_price'];
			$sale = $_POST['sale'];
			$new_price = $_POST['new_price'];
			$novinka = 0;
			if (isset($_POST['novinka'])) {
				$novinka = 1;
			}
			$name = $_POST['name'];
			$descr = nl2br($_POST['descr']);
			$img = $_FILES['img'];
			$model_id = sequery("SELECT * FROM sneakers_models WHERE model =:model AND status = 1 LIMIT 1", compact('model')); 
			if (empty($model_id)) {
				$qq = query("INSERT INTO sneakers_models (razdel, model) VALUES (:razdel,:model)", compact('razdel', 'model'));
				$model_id = DB::getInstance()->lastInsertId();
			}
			else{
				$model_id = $model_id['id'];
			}
			$model = $model_id;
			$sizes = explode(',', $size);
			array_walk($sizes, 'trim_value');
			$prodsizes = query("UPDATE sizes SET status = 0 WHERE product_id=:id",compact('id'));
			foreach ($sizes as $v) {
				$query = query("INSERT INTO sizes (product_id,size) VALUES (:id,:v)", compact('id','v'));
			}
			if ($img['name'][0] != '') {

				$query = query("UPDATE images SET status = 0 WHERE product_id=:id",compact('id'));
				$m = 0;
				while ($m < count($img['name'])) {
					if ($img['error'][$m] != 4) {		
						$type = substr($img['type'][$m], 6);
						$img_url = md5("athleticstore".$articul.$id.$m).".".$type;
						move_uploaded_file($_FILES['img']['tmp_name'][$m], '../catalog/'.$img_url);
						$query = query("INSERT INTO images (product_id,img_url) VALUES (:id,:img_url)", compact('id','img_url'));
					}
					$m++;
				}
			}
			$query = query("UPDATE catalog SET articul=:articul, brand_id=:brand_id, gender=:gender, name=:name, descr=:descr, old_price=:old_price, new_price=:new_price, sale=:sale, razdel=:razdel, category=:category, season=:season, color=:color, novinka=:novinka, model=:model WHERE id=:id", compact('articul', 'brand_id', 'gender', 'name', 'descr', 'old_price', 'new_price', 'sale', 'razdel', 'category', 'season', 'color', 'novinka', 'model', 'id'));
			header("Location: ".$_POST['ref']);
			break;
		case 'newprod':
			$razdel = $_POST['razdel'];
			$category = $_POST['category'];
			$gender = $_POST['gender'];
			$brand_id = $_POST['brand'];
			$season = $_POST['season'];;
			$articul = $_POST['articul'];
			$model = $_POST['model'];
			$size = $_POST['size'];
			$color = $_POST['color'];
			$old_price = $_POST['old_price'];
			$sale = $_POST['sale'];
			$new_price = $_POST['new_price'];
			$novinka = 0;
			if (isset($_POST['novinka'])) {
				$novinka = 1;
			}
			$name = $_POST['name'];
			$descr = nl2br($_POST['descr']);
			$img = $_FILES['img'];
			$model_id = sequery("SELECT * FROM sneakers_models WHERE model =:model AND status = 1 LIMIT 1", compact('model')); 
			if (empty($model_id)) {
				$qq = query("INSERT INTO sneakers_models (razdel, model) VALUES (:razdel,:model)", compact('razdel', 'model'));
				$model_id = DB::getInstance()->lastInsertId();
			}
			else{
				$model_id = $model_id['id'];
			}
			$model = $model_id;


			$query = query("INSERT INTO catalog (articul, brand_id, gender, name, descr, old_price, new_price, sale, razdel, novinka, category, season, color, model) VALUES (:articul, :brand_id, :gender, :name, :descr, :old_price, :new_price, :sale, :razdel, :novinka, :category, :season, :color, :model)", compact('articul', 'brand_id', 'gender', 'name', 'descr', 'old_price', 'new_price', 'sale', 'razdel', 'novinka', 'category', 'season', 'color', 'model'));
			$id = DB::getInstance()->lastInsertId();


			$sizes = explode(',', $size);
			array_walk($sizes, 'trim_value');
			foreach ($sizes as $v) {
				$query = query("INSERT INTO sizes (product_id,size) VALUES (:id,:v)", compact('id','v'));
			}

			if ($img['name'][0] != '') {
				$m = 0;
				while ($m < count($img['name'])) {
					if ($img['error'][$m] != 4) {		
						$type = substr($img['type'][$m], 6);
						$img_url = md5("athleticstore".$articul.$id.$m).".".$type;
						move_uploaded_file($_FILES['img']['tmp_name'][$m], '../catalog/'.$img_url);
						$query = query("INSERT INTO images (product_id,img_url) VALUES (:id,:img_url)", compact('id','img_url'));
					}
					$m++;
				}
			}
			header("Location: ".$_POST['ref']);
			break;	
		case 'add_tovar':
			$name = $_POST['name'];
			$descr = nl2br($_POST['descr']);
			$brand = $_POST['brand'];
			$gender = $_POST['gender'];
			$price = $_POST['price'];
			$intensive = $_POST['intensive'];
			$aromagroup = $_POST['aromagroup'];
			$year = $_POST['year'];
			$topnotes = $_POST['topnotes'];
			$middlenotes = $_POST['middlenotes'];
			$bottomnotes = $_POST['bottomnotes'];
			$novinka = 0;
			if (isset($_POST['novinka'])) {
				$novinka = 1;
			}

			$maxid = sequery("SELECT id FROM catalog ORDER BY id DESC LIMIT 1");
			$maxid = (int)$maxid['id'] + 1;
			$type = substr($_FILES['img']['type'], 6);
			$img_url = $maxid.'.'.$type;
			$query = query("INSERT INTO catalog (name, descr, brand, aromagroup, year, topnotes, middlenotes, bottomnotes, gender, img_url, intensive, price, novinka) VALUES (:name, :descr, :brand, :aromagroup, :year, :topnotes, :middlenotes, :bottomnotes, :gender, :img_url, :intensive, :price, :novinka)",
					compact('name', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'img_url', 'intensive', 'price', 'novinka'));

			move_uploaded_file($_FILES['img']['tmp_name'], '../catalog/'.$img_url);
			header('Location: main.php');
			break;
		case 'change_tovar':
			$id = $_POST['id'];
			$name = $_POST['name'];
			$descr = nl2br($_POST['descr']);
			$brand = $_POST['brand'];
			$gender = $_POST['gender'];
			$price = $_POST['price'];
			$intensive = $_POST['intensive'];
			$aromagroup = $_POST['aromagroup'];
			$year = $_POST['year'];
			$topnotes = $_POST['topnotes'];
			$middlenotes = $_POST['middlenotes'];
			$bottomnotes = $_POST['bottomnotes'];
			$status = 1;
			$novinka = 0;
			if (isset($_POST['novinka'])) {
				$novinka = 1;
			}
			if (isset($_POST['soldout'])) {
				$status = 2;
			}
			
			if ($_FILES['img']['error'] != 4) {
			 	$type = substr($_FILES['img']['type'], 6);	
			 	$img_url = $id.'.'.$type;
			 	move_uploaded_file($_FILES['img']['tmp_name'], '../catalog/'.$img_url);
			 	$query = query("UPDATE catalog SET name = :name, descr = :descr, brand =:brand, aromagroup =:aromagroup, year =:year, topnotes =:topnotes, middlenotes =:middlenotes, bottomnotes =:bottomnotes, gender =:gender, price =:price, intensive =:intensive, img_url =:img_url, novinka =:novinka, status =:status WHERE id = :id LIMIT 1",compact('name', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'price', 'intensive', 'img_url', 'novinka', 'status', 'id'));
		 	} 
		 	else{
		 		$query = query("UPDATE catalog SET name = :name, descr = :descr, brand =:brand, aromagroup =:aromagroup, year =:year, topnotes =:topnotes, middlenotes =:middlenotes, bottomnotes =:bottomnotes, gender =:gender, price =:price, intensive =:intensive, novinka =:novinka, status =:status WHERE id = :id LIMIT 1",compact('name', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'price', 'intensive', 'novinka', 'status', 'id'));
		 	}
		 	
		 	//print_r($_FILES['img']);

		 	header('Location: main.php');
		 	//print_r($_FILES);
			break;
		case 'change_assort':
			$id = $_POST['id'];
			$name = $_POST['name'];
			$cell = $_POST['cell'];
			$volume = $_POST['volume'];
			$refan = $_POST['refan'];
			if ($_FILES['img']['error'] != 4) {
			 	$type = substr($_FILES['img']['type'], 6);	
			 	$img_url = $id.'.'.$type;
			 	move_uploaded_file($_FILES['img']['tmp_name'], '../assort/'.$img_url);
			 	$query = query("UPDATE assort SET name = :name, cell = :cell, volume = :volume, refan = :refan, img_url = :img_url WHERE id = :id LIMIT 1",compact('name', 'cell', 'volume', 'refan', 'img_url', 'id'));
		 	} 
		 	else{
		 		$query = query("UPDATE assort SET name = :name, cell = :cell, volume = :volume, refan = :refan WHERE id = :id LIMIT 1",compact('name', 'cell', 'volume', 'refan', 'id'));
		 	}
		 	
		 	//print_r($_FILES['img']);

		 	header('Location: assortiment.php');
		 	//print_r($_FILES);
			break;		
		case 'set_sort':
			$_SESSION['sort'] = $_POST['sort'];
			echo 'ok';
			break;	
		case 'remove_email':
			$id = $_POST['email_id'];
			$query = query("UPDATE emails SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;	
		case 'add_email':
			$email = $_POST['new_email'];
			$phone = $_POST['new_phone'];
			$query = query("INSERT INTO emails (email, phone) VALUES (:email, :phone)", compact('email', 'phone'));
			echo 'ok';
			break;
		case 'send_mailing':
			$name = $_POST['name'];
			$title = $_POST['title'];
			$text = nl2br($_POST['text']);
			$type = substr($_FILES['img']['type'], 6);	

			$imgurl = 'mailimg.'.$type;
			move_uploaded_file($_FILES['img']['tmp_name'], 'mailimg/'.$imgurl);

			$to = 'mail@bk.ru';
			$subject = $name;
			$message = '
			<html>
			<head>
			  <title>'.$title.'</title>
			</head>
			<body>
			  <h1>'.$title.'</h1>
			  <p>'.$text.'</p>
			  <img src="https://refanparfum.lv/admin/mailimg/'.$imgurl.'" style="width: 80%;">
			</body>
			</html>
			';

			$query = sequery("SELECT email FROM emails WHERE status = 1");
			if (!isset($query[0]['email'])) {
				$query = array('1' => $query);
			}


			foreach ($query as $v) {
				$to = $v['email'];
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= 'To: Mailer <'.$to.'>' . "\r\n";
				$headers .= 'From: RefanParfum.lv <info@refanparfum.lv>' . "\r\n";
				mail($to, $subject, $message, $headers);
			}

			header("Location: main.php");

			//echo 'https://refanparfum.lv/mailimg/'.$imgurl;
			
			break;
		case 'send_smsing':
			$message = $_POST['text'];
			$query = sequery("SELECT phone FROM emails WHERE status = 1");
			if (!isset($query[0]['email'])) {
				$query = array('1' => $query);
			}
			foreach ($query as $v) {
				if ($v['phone'] != '') {
					$v['phone'] = str_replace(' ', '', $v['phone']);
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
				                      <recipient>'.$v['phone'].'</recipient>
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
				}
			}
			header("Location: emails.php");
			break;	
		case 'add_automat':
			
			$adress = $_POST['adress'];
			$info = nl2br($_POST['info']);
			$map_frame = $_POST['map_frame'];

			$maxid = sequery("SELECT id FROM pakomats ORDER BY id DESC LIMIT 1");
			$maxid = (int)$maxid['id'] + 1;
			$type_outside = substr($_FILES['img_outside']['type'], 6);
			$img_outside_url = $maxid.'out.'.$type_outside;

			$type_inside = substr($_FILES['img_inside']['type'], 6);
			$img_inside_url = $maxid.'in.'.$type_inside;

			$img_outside = $img_outside_url;
			$img_inside = $img_inside_url;
			$ordering = $maxid;
			$query = query("INSERT INTO pakomats (ordering, adress, img_outside, img_inside, map_frame, info) VALUES (:ordering, :adress, :img_outside, :img_inside, :map_frame, :info)", compact('ordering', 'adress', 'img_outside', 'img_inside', 'map_frame', 'info'));

			move_uploaded_file($_FILES['img_outside']['tmp_name'], '../pakomats/'.$img_outside_url);
			move_uploaded_file($_FILES['img_inside']['tmp_name'], '../pakomats/'.$img_inside_url);
			header('Location: automats.php');
			break;	
		case 'change_automat':
			//print_r($_POST);
			$id = $_POST['id'];
			$adress = $_POST['adress'];
			$info = nl2br($_POST['info']);
			$map_frame = $_POST['map_frame'];
			//echo $info;
			
			if ($_FILES['img_outside']['error']!=4 && $_FILES['img_inside']['error']!=4) {
				echo 'outside & inside';
				$maxid = $id;
				$type_outside = substr($_FILES['img_outside']['type'], 6);
				$img_outside_url = $maxid.'out.'.$type_outside;

				$type_inside = substr($_FILES['img_inside']['type'], 6);
				$img_inside_url = $maxid.'in.'.$type_inside;

				$img_outside = $img_outside_url;
				$img_inside = $img_inside_url;

				$query = query("UPDATE pakomats SET adress = :adress, img_outside = :img_outside, img_inside = :img_inside, info = :info, map_frame =:map_frame WHERE id = :id LIMIT 1", compact('adress', 'img_outside', 'img_inside', 'map_frame', 'info', 'id'));

				move_uploaded_file($_FILES['img_outside']['tmp_name'], '../pakomats/'.$img_outside_url);
				move_uploaded_file($_FILES['img_inside']['tmp_name'], '../pakomats/'.$img_inside_url);
				
			}
			elseif ($_FILES['img_outside']['error']!=4 && $_FILES['img_inside']['error']==4) {
				echo 'outside';
				$maxid = $id;
				$type_outside = substr($_FILES['img_outside']['type'], 6);
				$img_outside_url = $maxid.'out.'.$type_outside;

				$img_outside = $img_outside_url;

				$query = query("UPDATE pakomats SET adress = :adress, img_outside = :img_outside, info = :info, map_frame =:map_frame WHERE id = :id LIMIT 1", compact('adress', 'img_outside', 'map_frame', 'info', 'id'));

				move_uploaded_file($_FILES['img_outside']['tmp_name'], '../pakomats/'.$img_outside_url);
				
			}

			elseif ($_FILES['img_outside']['error']==4 && $_FILES['img_inside']['error']!=4) {
				echo 'inside';
				$maxid = $id;
				$type_inside = substr($_FILES['img_inside']['type'], 6);
				$img_inside_url = $maxid.'out.'.$type_inside;

				$img_inside = $img_inside_url;

				$query = query("UPDATE pakomats SET adress = :adress, img_inside = :img_inside, info = :info, map_frame =:map_frame WHERE id = :id LIMIT 1", compact('adress', 'img_inside', 'map_frame', 'info', 'id'));

				move_uploaded_file($_FILES['img_inside']['tmp_name'], '../pakomats/'.$img_inside_url);
				
			}
			else{
				echo 'none';
				$query = query("UPDATE pakomats SET adress = :adress, info = :info, map_frame =:map_frame WHERE id = :id", compact('adress', 'info', 'map_frame', 'id'));
			}
			//echo $query;
			header('Location: automats.php');
			
			break;
		case 'remove_automat':
			$id = $_POST['automat_id'];
			$query = query("UPDATE pakomats SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;	
		case 'add_assorti':
			$automat_id = $_POST['automat_id'];
			$name = $_POST['name'];
			$refan = $_POST['refan'];
			$price = $_POST['price'];
			$query = query("INSERT INTO assortiment (automat_id, name, refan, price) VALUES (:automat_id, :name, :refan, :price)", compact('automat_id', 'name', 'refan', 'price'));
			echo 'ok';
			break;
		case 'remove_assorti':
			$id = $_POST['ass_id'];
			$query = query("UPDATE assortiment SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;	
			break;
		case 'auth':
			if ($_POST['login'] != 'cc97733' && $_POST['password'] != 'Y3kWO2otOv6S') {
				echo 'invalid_form';
			}
			elseif ($_POST['login'] != 'cc97733') {
				echo 'invalid_login';
			}
			elseif ($_POST['password'] != 'Y3kWO2otOv6S') {
				echo 'invalid_password';
			}
			else{
				setcookie('auth', 'Y3kWO2otOv6S');
				echo 'valid_form';
			}
			break;	

		case 'search':
			$query = $_POST['query'];
			$razdd = $_POST['razdel'];
			header('Location: main.php?razdel='.$razdd.'&query='.$query);
			break;									
		default:
			# code...
			break;
	}
}
?>