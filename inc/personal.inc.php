
<?php if(isset($_SESSION['loggedUser'])){?>
    <div id="MenuPersonal">
    <a href="http://<?=$_SERVER["HTTP_HOST"]?>/index.php?id=personal">Мои данные</a>
    </div>
    <div id="MenuPersonal">
    <a href="http://<?=$_SERVER["HTTP_HOST"]?>/index.php?id=personal&page=myorders">Мои заказы</a>
    </div>
    <br>
<?php
}
$id = strtolower(strip_tags(trim($_GET['id'])));
if($id=='personal' && $_GET['page']!='myorders')
    include 'enterInformation.php';
else if($_GET['page']=='myorders')
    include 'myOrders.php';
?>
