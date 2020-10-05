<?php
if(isset($_COOKIE['basket']))
{   //принимаем значения
    require_once "inc/class.inc.php";
    $surname = $minimarket->clearstring($_POST['surname']);
    $name = $minimarket->clearstring($_POST['name']);
    $patronymic = $minimarket->clearstring($_POST['patronymic']);
    $email = $minimarket->clearstring($_POST['email']);
    $phone = $minimarket->clearstring($_POST['phone']);
    if(!empty($_POST['street']) && !empty($_POST['house']))
        $address = $minimarket->clearstring('Улица: '.$_POST['street'].', дом: '.$_POST['house'].', квартира: '.$_POST['flat']);
    else
        $address = $minimarket->clearstring($_POST['savedAddress']);
    if(!$address)
        $_SESSION['error']="Мы связались с Мэром вашего города и он рассказал, что такого адреса нет";
    $time = $minimarket->clearstring($_POST['time']);
    $time=strtotime($time);//делаем время временной меткой, а не строкой
    $wantTalking=(int)$_POST['WantTalking'];

    if(!($email=filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)))
        $_SESSION['error']="Указанный вами адрес email не может существовать в соответствии с RFC 822";
    if(!$phone = validate_russian_phone_number($phone))
        $_SESSION['error']="Кажется, на такой номер телефона мы не дозвонимся. Как же тогда мы свяжемся с нашим любымым клиентом?";
    $t=time();
    if((time()-$time>86400)||(($time-$t)>691200))
        $_SESSION['error']="Возможно, вы потерялись во времени или просто на выбранную дату оформить заказ невозможно. Попробуйте другой день.";
    if(!empty($surname) and !empty($name) and !empty($email) and !empty($phone) and !empty($address) and !empty($time) and !isset($_SESSION['error']))
        $id = $minimarket->addOrder($surname, $name, $patronymic, $email, $phone, $address, $time, $wantTalking, $_COOKIE['basket']);
    else if (!isset($_SESSION['error']))    
        $_SESSION['error']='Укажите все параметры';
    if(isset($_SESSION['error']))                   //если есть ошибки
        {   $_SESSION['data']=$_POST;
            header("Location: index.php?id=createOrder");
        }
    else                                                //если заказ оформлен
        {   $_SESSION['order_id']=$id;
            setcookie('basket', $basket, -0x7FFFFFFF);
            if($user=$minimarket->searchUserByEmail($email))            //если пользователь зарегистрирован
                {
                    if(!$minimarket->SearchUserInformationById($user['user_id'])) //если дополнительной информации о пользователе не найдено
                        $minimarket->addUserInformation($user['user_id'],$surname, $name, $patronymic, $phone, $address);   //сохранить введённую информацию
                }
            header("Location: index.php?id=thanksForOrder");
        }
} 
else    
    header("Location: ../index.php?id=catalog");    

function validate_russian_phone_number($tel)
{
    $tel = trim((string)$tel);
    if (!$tel) return false;
    $tel = preg_replace('#[^0-9+]+#uis', '', $tel);
    if (!preg_match('#^(?:\\+?7|8|)(.*?)$#uis', $tel, $m)) return false;
    $tel = '+7' . preg_replace('#[^0-9]+#uis', '', $m[1]);
    if (!preg_match('#^\\+7[0-9]{10}$#uis', $tel, $m)) return false;
    return $tel;
}