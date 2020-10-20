<?php
if(!isset($_COOKIE['basket']))
{
    //$basket = ['orderid' => uniqid()];
    $basket[$_POST['productId']] = 1; 
    saveBasket();
}
else 
{
    $basket = unserialize(base64_decode($_COOKIE['basket']));
    if(isset($basket[$_POST['productId']]))
        $basket[$_POST['productId']]++;
    else
        $basket[$_POST['productId']] = 1; 
    saveBasket();
}
echo json_encode(array('success' => 1));
function saveBasket()
{
    $basket = base64_encode(serialize($GLOBALS['basket']));
    setcookie('basket', $basket, 0x7FFFFFFF);
}