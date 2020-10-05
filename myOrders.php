<?php 
if(!isset($_SESSION['loggedUser']))
{
    echo "<h1>Вы не вошли в аккаунт</h1>";
    echo "<h3><a href='../index.php?id=login'>Войти в аккаунт</a><br>";
    echo "<a href='../index.php?id=signup'>Регистрация</a><br>";
    goto end;
}
$orders=$minimarket->searchOrdersByEmail($_SESSION['loggedUser']['email']);
foreach ($orders as $order)
{?>
<h2>Заказ №<?=$order['order_id']?></h2>
<div id="orderInformation">
    <b>Адрес:</b> <?=$order['address']?><br>
    <b>Дата доставки:</b> <?=date('d-m-Y',$order['time'])?><br>
    <?php if($order['want_talking'])
                echo "Менеджер обязательно свяжется с вами по телефону {$order['phone']}";
            else
                echo "Мы не будем вас беспокоить";
    ?>
</div>
<?php 
    $basket=unserialize(base64_decode($order['ordered_products']));
    $goods = array_keys($basket); //берём только ключи
    $IDs = implode(",", $goods); //переводим в строку через запятую
    unset($goods);
    $goods=$minimarket->SelectProductsByID($IDs);

    $n=count($goods);
    for($i=0;$i<$n;$i++)        //добавляем количество каждого из товаров в корзине
    {
        $goods[$i]['quantity']=$basket[$goods[$i]['id']];
    }
$summ=0;
foreach($goods as $item)
    {
        $summ+=$item['price']*$item['quantity']; //считаем стоимость товаров
        ?>
       <h2><?=$item['name']?> <br></h2>
    <div id="basketImageBlock">
            <img src="../images/showImage.php?product_id=<?=$item['id']?>"> 
    </div>
    <div id="basketDescription">
        <div id="leftUnder">
                <div id="price"> <?=$item['price']?> р.</div>
        </div>
    </div>
 <?php }?>
 <h3>Итого: <?=$summ?>р.</h3>
<hr>
<?php } end:?>