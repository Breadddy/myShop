<?php ob_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
 <link rel="shortcut icon" href="images/SmallMyShopLogo2.png" type="image/png">
</head>
<?php 
    echo '<link rel="stylesheet" type="text/css" href="../inc/style.css" />';
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', '1');
    setlocale (LC_ALL, "RU_ru");
    require "secure.inc.php";
require_once "../inc/class.inc.php"; 
include "../inc/title.inc.php";
include "../inc/head.inc.php";
echo '<div id="content">';
require_once '../inc/routing.inc.php';
ob_flush();
echo '</div>';?>

<body>
<div id="nav">
    <!-- Навигация -->
    <h2>Меню админки</h2>
    <ul>
        <li><a href='admin.php'>Главная</a></li>
        <li><a href='admin.php?id=editProducts'>Редактировать товары</a></li>
        <li><a href='admin.php?id=addProducts'>Добавить товар</a></li>
        <li><a href='admin.php?id=showOrders'>Список заказов</a></li>
    </ul>
    <!-- Навигация -->
</div>
</body>