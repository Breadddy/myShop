<span id="sortOrders">
<?php
require "secure.inc.php";
if(!isset($_GET['firstitem']))
    $_GET['firstitem']=0;
if(!isset($_GET['show']))
    $_GET['show']='actual';
switch($_GET['show'])
{
    case 'needtocall':
        {   $k=$minimarket->countOrders('wantTalking');
            echo "<h1>Заказы, требующие звонка: $k</h1>";
            echo "<a href='../admin/admin.php?id=showOrders&show=all'>Показать все заказы </a>";
            echo "<a href='../admin/admin.php?id=showOrders&show=actual'>Показать актуальные заказы </a>";
            $orders=$minimarket->selectFirstNOrders($_GET['firstitem'],10,'wantTalking');
            break;
        }
    case 'all':
        {   $k=$minimarket->countOrders();
            echo "<h1>Все когда-либо оформленные заказы: $k</h1>";
            $orders=$minimarket->selectFirstNOrders($_GET['firstitem'],10);
            echo "<a href='../admin/admin.php?id=showOrders&show=needtocall'>Показать заказы, требующие звонка</a>";
            echo "<a href='../admin/admin.php?id=showOrders&show=actual'>Показать актуальные заказы </a>";
            break;
        }
    case 'actual':
        {   $k=$minimarket->countOrders('actual');
            echo "<h1>Актуальные заказы: $k</h1>";
            $orders=$minimarket->selectFirstNOrders($_GET['firstitem'],10, 'actual');
            echo "<a href='../admin/admin.php?id=showOrders&show=needtocall'>Показать заказы, требующие звонка</a>";
            echo "<a href='../admin/admin.php?id=showOrders&show=all'>Показать все заказы</a>";
            break;
        }
    
}
echo '</span>';
//print_r($orders);
foreach ($orders as $order)
{?>
<h2>Заказ №<?=$order['order_id']?></h2>
<div id="orderInformation">
    <b>ФИО:</b> <?=$order['surname'].' '.$order['name'].' '.$order['patronymic']?><br>
    <b>Email:</b> <?=$order['email']?><br>
    <b>Телефон:</b> <?=$order['phone']?><br>
    <b>Адрес:</b> <?=$order['address']?><br>
    <b>Дата доставки:</b> <?=date('d-m-Y',$order['time'])?><br>
    <?php if($order['want_talking'])
                echo "Клиенту необходимо позвонить";
            else
                echo "Звонить не нужно";
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
                <div id="price"> <?=$item['price']?> р.<br><br>
                <?=$item['quantity']?>шт.</div>
        </div>
    </div>
 <?php }?>
 <h3>Итого: <?=$summ?>р.</h3>
<hr>

<?php }?>
<div id="pageNumber">
<?php 
$k=ceil($k/10); //k - требуемое количество страниц
for($i=0;$i<$k;$i++)
{
    $pageNumber=$i+1;
    $bdpagenumber=$i*10;
    echo '<a href='."admin.php?id=showOrders&show={$_GET['show']}&firstitem=$bdpagenumber".">{$pageNumber}</a>";
}
?>
    </div>