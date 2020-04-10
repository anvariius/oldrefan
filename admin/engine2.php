<?php
ini_set('max_execution_time', 1600000);
ini_set('memory_limit', '-1');
include '../bt/pdo.php';


if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'set_sort':
			session_start();
			$_SESSION['sort'] = $_GET['sort'];
			break;
		
		default:
			# code...
			break;
	}
}
if (isset($_POST['token']) && $_POST['token'] == $token2 && isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'remove_tovar':
			$id = $_POST['product_id'];
			$query = query("UPDATE catalog SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'remove_assort':
			$id = $_POST['product_id'];
			$query = query("UPDATE assort SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;	
		case 'remove_brand':
			$id = $_POST['brand_id'];
			$query = query("UPDATE brands SET status = 0 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'restore_tovar':
			$id = $_POST['product_id'];
			$query = query("UPDATE catalog SET status = 1 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'restore_assort':
			$id = $_POST['product_id'];
			$query = query("UPDATE assort SET status = 1 WHERE id = :id LIMIT 1", compact('id'));
			echo 'ok';
			break;
		case 'add_tovar':
			$name = $_POST['name'];
			$refan = $_POST['refan'];
			$kosmetic_type = $_POST['kosmetic_type'];
			$serie = $_POST['serie'];
			$stock = $_POST['stock'];
			$volume = $_POST['volume'];
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
			$query = query("INSERT INTO catalog (name, refan, kosmetic_type, serie, stock, volume, descr, brand, aromagroup, year, topnotes, middlenotes, bottomnotes, gender, img_url, intensive, price, novinka) VALUES (:name, :refan, :kosmetic_type, :serie, :stock, :volume, :descr, :brand, :aromagroup, :year, :topnotes, :middlenotes, :bottomnotes, :gender, :img_url, :intensive, :price, :novinka)",
					compact('name', 'refan', 'kosmetic_type', 'serie', 'stock', 'volume', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'img_url', 'intensive', 'price', 'novinka'));

			move_uploaded_file($_FILES['img']['tmp_name'], '../catalog/'.$img_url);
			header('Location: main.php');
			break;
		case 'add_assort':
			$name = $_POST['name'];
			$refan = $_POST['refan'];
			$cell = $_POST['cell'];
			$volume = $_POST['volume'];
			$refan = $_POST['refan'];

			$maxid = sequery("SELECT id FROM assort ORDER BY id DESC LIMIT 1");
			$maxid = (int)$maxid['id'] + 1;
			$type = substr($_FILES['img']['type'], 6);
			$img_url = $maxid.'.'.$type;
			$query = query("INSERT INTO assort (name, cell, volume, refan, img_url) VALUES (:name, :cell, :volume, :refan, :img_url)",
					compact('name', 'cell', 'volume', 'refan', 'img_url'));

			move_uploaded_file($_FILES['img']['tmp_name'], '../assort/'.$img_url);
			header('Location: assortiment.php');
			break;	
		case 'add_brand':
			$name = $_POST['name'];
			$maxid = sequery("SELECT id FROM brands ORDER BY id DESC LIMIT 1");
			$maxid = (int)$maxid['id'] + 1;
			$type = substr($_FILES['img']['type'], 6);
			$img_url = $maxid.'b.'.$type;
			move_uploaded_file($_FILES['img']['tmp_name'], '../brands/'.$img_url);
			$query = query("INSERT INTO brands (name, img_url) VALUES (:name, :img_url)",
					compact('name', 'img_url'));
			header('Location: main.php?category=brands');
			break;
		case 'change_tovar':
			$id = $_POST['id'];
			$name = $_POST['name'];
			$refan = $_POST['refan'];
			$kosmetic_type = $_POST['kosmetic_type'];
			$serie = $_POST['serie'];
			$stock = $_POST['stock'];
			$descr = nl2br($_POST['descr']);
			$brand = $_POST['brand'];
			$volume = $_POST['volume'];
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
			 	$query = query("UPDATE catalog SET name = :name, refan = :refan, kosmetic_type=:kosmetic_type, serie=:serie, stock=:stock, volume = :volume, descr = :descr, brand =:brand, aromagroup =:aromagroup, year =:year, topnotes =:topnotes, middlenotes =:middlenotes, bottomnotes =:bottomnotes, gender =:gender, price =:price, intensive =:intensive, img_url =:img_url, novinka =:novinka, status =:status WHERE id = :id LIMIT 1",compact('name', 'refan', 'kosmetic_type', 'serie', 'stock', 'volume', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'price', 'intensive', 'img_url', 'novinka', 'status', 'id'));
		 	} 
		 	else{
		 		$query = query("UPDATE catalog SET name = :name, refan = :refan, kosmetic_type=:kosmetic_type, serie=:serie, stock=:stock, volume = :volume, descr = :descr, brand =:brand, aromagroup =:aromagroup, year =:year, topnotes =:topnotes, middlenotes =:middlenotes, bottomnotes =:bottomnotes, gender =:gender, price =:price, intensive =:intensive, novinka =:novinka, status =:status WHERE id = :id LIMIT 1",compact('name', 'refan', 'kosmetic_type', 'serie', 'stock', 'volume', 'descr', 'brand', 'aromagroup', 'year', 'topnotes', 'middlenotes', 'bottomnotes', 'gender', 'price', 'intensive', 'novinka', 'status', 'id'));
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
			session_start();
			$_SESSION['sort'] = $_POST['sort'];
			$_SESSION['sort_text'] = $_POST['sort_text'];
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
			echo $imgurl.'<br>';
			echo $_FILES['img']['tmp_name'];

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
			  <img src="https://refanparfum.lv/mailimg/'.$imgurl.'" style="width: 80%;">
			</body>
			</html>
			';
			
			$query = sequery("SELECT email FROM emails WHERE status = 1");
			if (!isset($query[0]['email'])) {
				$query = array('1' => $query);
			}
			/*

			foreach ($query as $v) {
				$to = $v['email'];
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= 'To: Mailer <'.$to.'>' . "\r\n";
				$headers .= 'From: RefanParfum.lv <info@refanparfum.lv>' . "\r\n";
				mail($to, $subject, $message, $headers);
			}
			*/

			//header("Location: main.php");

			//echo 'https://refanparfum.lv/mailimg/'.$imgurl;
			echo "Подождите";

			foreach ($query as $v) {
				$token = '6775g37nuu6w9ujwe5obojou84jhdgtdr8krkpcy';
				$email = $v['email'];
				$params = [
					'format' => 'json',
					'api_key' => $token,
					'email' => $email,
					'sender_name' => 'refanparfum',
					'sender_email' => 'info@refanparfum.lv',
					'subject' => $subject,
					'body' => $message,
					'list_id' => '19981550'
				];

				$get_params = http_build_query($params);
				$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));
				print_r($result);
			}


			header("Location: main.php");
			
			break;
		case 'sendEmailUni':
			$email_id = $_POST['email_id'];
			$name = $_POST['name'];
			$title = $_POST['title'];
			$isImg = $_POST['isImg'];
			$img_name = $_POST['img_name'];
			$text = nl2br($_POST['text']);

			if($isImg=='false'){
				$isImg = "display: none;";
			}
			else{
				$isImg = "";
			}

			$query = sequery("SELECT email FROM emails WHERE id =:email_id LIMIT 1", compact('email_id'));


			$subject = $name;
			$message = '
			<html>
			<head>
			  <title>'.$title.'</title>
			</head>
			<body>
			  <h1>'.$title.'</h1>
			  <p>'.$text.'</p>
			  <img src="https://refanparfum.lv/admin/mailimg/'.$img_name.'" style="width: 80%;'.$isImg.'">
			</body>
			</html>
			';

			$token = '6775g37nuu6w9ujwe5obojou84jhdgtdr8krkpcy';
			$email = $query['email'];
			$params = [
				'format' => 'json',
				'api_key' => $token,
				'email' => $email,
				'sender_name' => 'refanparfum',
				'sender_email' => 'info@refanparfum.lv',
				'subject' => $subject,
				'body' => $message,
				'list_id' => '19981550'
			];

			$get_params = http_build_query($params);
			$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));
			$result->email = $email;

			echo json_encode($result);
			break;	
		
		case 'uploadImageUni':
			$str_characters = [0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

			$string = '';
		    for ($i = 20; $i > 0; $i--){
		        $string .= $str_characters[rand(0, 55)];
		    }
			$img_name = $string.'.png';


			if ( 0 < $_FILES['file']['error'] ) {
		        echo 'error';
		    }
		    else {
		        move_uploaded_file($_FILES['file']['tmp_name'], 'mailimg/'.$img_name);
		    }

		    echo $img_name;

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
		case 'fb_remove':
			$id = $_POST['fb_id'];
			$query = query("UPDATE feedback SET status=0 WHERE id=:id",compact('id'));
			echo 'ok';
			break;
		case 'fb_access':
			$id = $_POST['fb_id'];
			$query = query("UPDATE feedback SET status=2 WHERE id=:id",compact('id'));
			echo 'ok';
			break;	
		case 'fb-answer':
			$id = $_POST['fb-id'];
			$answer = $_POST['answer'];
			$query = query("UPDATE feedback SET answer=:answer WHERE id=:id",compact('answer','id'));
			header("Location: feedback.php");
			break;	
		case 'edit-kosmetic':
			$id = $_POST['id'];
			$name = $_POST['name'];
			$descr = $_POST['descr'];
			$query = query("UPDATE kosmetica SET name=:name, descr=:descr WHERE id=:id",compact('name', 'descr', 'id'));
			header("Location: kosmetica.php");
			break;							
		default:
			# code...
			break;
	}
}
?>