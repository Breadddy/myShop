<?php
if(isset($_COOKIE['basket']))
{   $basket = unserialize(base64_decode($_COOKIE['basket']));
    $goods = array_keys($basket); //берём только ключи
    //array_shift($goods);          //убираем первый элемент orderid
}
if(!$goods)          //если корзина пуста
    {   echo "<h3>Ваша корзина пуста";
        goto end;
    }
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
        if ($item['available']==0)  //если в заказе есть отсутствующий товар, не дать оформить заказ
                $dis=1;
        $summ+=$item['price']*$item['quantity']; //считаем стоимость товаров
        ?>
       <h2><?=$item['name']?> <br></h2>
    <div id="basketImageBlock">
            <img src="images/showImage.php?product_id=<?=$item['id']?>"> 
    </div>
    <div id="basketDescription">
        <div id="leftUnder">
                <div id="available"><?=($item['available']) ? "Есть в наличии" : "Нет в наличии"?> </div>   
                <div id="price"> <?=$item['price']?> р.</div>
        </div>
        <div id="rightUnder"> 
                <form action="editingBasket.php" method="POST"> 
                    <input type="hidden" name=productId value=<?=$item['id']?>>
                    <span id='quantity'>
                            <button type="submit" name="edit" value="minus">-</button>
                            <?=$item['quantity']?>
                            <button type="submit" name="edit" value="plus">+</button>
                    </span>
                    <button type="submit" name="edit" value="delete"> Удалить из корзины</button>
                </form>
        </div>
    </div>
 <?php }?>
 <hr>
    <form action="index.php?id=createOrder" method="POST">
    <span id="summ">Итого: <?=$summ?>р.
        <button id="createOrder" name="createOrder" value='pushed' type="submit" <?=($dis)?'disabled':''?>> Оформить заказ</button>
    </span>
    </form>
 <?php 
 if($dis)//если есть отсутствующие товары
        echo '<h3>Уберите из корзины товары товары, которых нет в наличии для того, чтобы оформить заказ';
 end:?>
