<?php
$id = strtolower(strip_tags(trim($_GET['id'])));
if($_SERVER["SCRIPT_NAME"]=="/admin/admin.php")
	switch ($id){
		case 'editproducts': $title="Редактирование товаров"; break;
		case 'addproducts': $title="Добавление продукта"; break;
		case 'showorders': $title="Список заказов"; break;
		default: $title="Главная страница админки"; break;
	}
else
switch($id){
	case 'paydeliver': {$title="Доставка и оплата"; break;};
		case 'about': $title="О нас"; break;
		case 'catalog': $title="Каталог товаров"; break;
		case 'login': $title="Вход на сайт"; break;
		case 'signup': $title="Регистрация"; break;
		case 'basket': $title="Корзина"; break;
		case 'createorder': $title="Оформление нового заказа"; break;
		case 'thanksfororder': $title=''; break;
		case 'personal': $title='Личный кабинет'; break;
		default: $title="Главная страница"; break;
	}	
echo "<head> <title> $title </title> </head>";