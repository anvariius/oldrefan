<?php
$subject = 'Subject of mail';
$message = '
<html>
<head>
  <title>Титулник письма</title>
</head>
<body>
  <h1></h1>
  <p>Заказывайте титульник</p>
</body>
</html>
';

$token = '6qzj1f8hij9fyrf1fgtwb85bjdxkarkwdqehx3wo';
$params = [
	'format' => 'json',
	'api_key' => $token,
	'email' => 'anvar8ku@mail.ru',
	'sender_name' => 'Anvar',
	'sender_email' => 'anvar8ku@gmail.com',
	'subject' => $subject,
	'body' => $message,
	'list_id' => '19962860'
];

$get_params = http_build_query($params);
$result = json_decode(file_get_contents('https://api.unisender.com/ru/api/sendEmail?'. $get_params));

print_r($result);
?>