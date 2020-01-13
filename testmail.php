<?php
$to  = "<anvar8ku@mail.ru>";//почта админа
$subject = "RefanParfum.lv"; 
$headers  = "Content-type: text/html; charset=utf8 \r\n"; 
$headers .= "From: От кого письмо <info@refanparfum.lv>\r\n";
$msgg = '<b>Спасибо за заявку! Ваш заказ был принят! Наш консультант вскоре свяжется с вами!</b>';
mail($to, $subject, $msgg, $headers);
?>