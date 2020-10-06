<?php require_once "inc/class.inc.php";
ob_start();?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <link rel="shortcut icon" href="images/SmallMyShopLogo2.png" type="image/png">
</head>
<?php
echo '<link rel="stylesheet" type="text/css" href="inc/style.css" />';
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', '1');
setlocale(LC_ALL, "RU_ru");

include "inc/title.inc.php";
include "inc/head.inc.php";
?>

<body>
<div id="content">
<?php require_once 'inc/routing.inc.php'; 
ob_flush();?>

</div>
    <div id="nav">
        <!-- Навигация -->
        <h2>Меню</h2>
        <ul>
            <li><a href='index.php?id=catalog'>Каталог товаров</a></li>
            <li><a href='index.php?id=payDeliver'>Доставка и оплата</a></li>
            <li><a href='index.php?id=about'>О нас</a></li>
            <?php
            if ((isset($_SESSION['loggedUser'])) && ($_SESSION['loggedUser']['login'] == 'admin'))    //если залогинился админ
                echo "<li><a href='admin/admin.php'>Админка</a></li>";
            else if (isset($_SESSION['loggedUser']))
                echo "<li><a href='index.php?id=personal'>Личный кабинет</a></li>";
            ?>
        </ul>
        <!-- Навигация -->
    </div>
</body>