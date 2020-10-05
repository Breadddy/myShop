<?php
if(isset($_POST['productId']))
{
    switch($_POST['edit'])
    {
        case "delete": {
            deleteProduct();
            break;
        }
        case "plus":{
            plus();
            break;
        }
        case "minus":{
            minus();
        break;
        }
    }
}
header("Location: {$_SERVER['HTTP_REFERER']}");

function saveBasket($basket)
{
    $basket = base64_encode(serialize($basket));
    setcookie('basket', $basket, 0x7FFFFFFF);
}
function deleteProduct()//удалить продукт из корзины
{
    $basket = unserialize(base64_decode($_COOKIE['basket']));
    unset($basket[$_POST['productId']]);
    saveBasket($basket);
}
function plus()//увеличить колво продукта в корзине на 1
{
    $basket = unserialize(base64_decode($_COOKIE['basket']));
    $basket[$_POST['productId']]++;
    saveBasket($basket);
}
function minus()
{
    $basket = unserialize(base64_decode($_COOKIE['basket']));
    $basket[$_POST['productId']]--;
    if($basket[$_POST['productId']]==0)
        {   deleteProduct();
            return false;
        }
    saveBasket($basket);
}