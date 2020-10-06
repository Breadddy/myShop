<div id='logo'>
<?php 

if((isset($_SESSION['loggedUser'])) && ($_SESSION['loggedUser']['login']=='admin')&&($_SERVER["SCRIPT_NAME"]=="/admin/admin.php"))	//если залогинился админ
    echo '<a href="admin.php"><img src="../images/MyShopAdminLogo.png"></div></a>';
else 
    echo '<a href="index.php"><img src="../images/MyShopLogo.png"></div></a>'
                    ?>
<div id='title'><h1><?=$title?></h1></div>
<div id=user>
<?php 
if (isset($_SESSION['loggedUser']))
{
    if(($_SESSION['loggedUser']['login']=='admin')&&($_SERVER["SCRIPT_NAME"]=="/admin/admin.php"))
        echo '<p>Добро пожаловать, '.$_SESSION['loggedUser']['login'].'<br>';
    else
        echo '<p>Добро пожаловать, <a href="index.php?id=personal"><u>'.$_SESSION['loggedUser']['login'].'</u></a><br>';
    echo "<a href='../index.php?id=logout&ref=$id'>Выйти</a><br></p>";
}
else
{    echo "<a href='index.php?id=signup'>Зарегистрироваться</a><br>";
     echo "<a href='index.php?id=login'>Войти в аккаунт</a><br>";
}?>
</div>
<div id="basket">
    <?php if(!((isset($_SESSION['loggedUser'])) && ($_SESSION['loggedUser']['login']=='admin')))	//если залогинился пользователь
    echo '<a href="index.php?id=basket"><img src="../images/basketImage.php"></div></a>';?>
</div>
    