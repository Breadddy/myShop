<?php
require_once "inc/class.inc.php";
if(isset($_SESSION['loggedUser']))
{   //принимаем значения
    $surname = $minimarket->clearstring($_POST['surname']);
    $name = $minimarket->clearstring($_POST['name']);
    $patronymic = $minimarket->clearstring($_POST['patronymic']);
    $email = $minimarket->clearstring($_POST['email']);
    $phone = $minimarket->clearstring($_POST['phone']);
    if(!empty($_POST['street']) && !empty($_POST['house']))
        $address = $minimarket->clearstring('Улица: '.$_POST['street'].', дом: '.$_POST['house'].', квартира: '.$_POST['flat']);
    else if(empty($_POST['street']) && empty($_POST['flat']) && empty($_POST['house']))
        $address = $minimarket->clearstring($_POST['savedAddress']);
    if(!$address)
        $_SESSION['error']="Мы связались с Мэром вашего города и он рассказал, что такого адреса нет";
    if(!($email=filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)))
        $_SESSION['error']="Указанный вами адрес email не может существовать в соответствии с RFC 822";
    if(!$phone = validate_russian_phone_number($phone))
        $_SESSION['error']="Кажется, на такой номер телефона мы не дозвонимся. Как же тогда мы свяжемся с нашим любымым клиентом?";
    if(!empty($surname) and !empty($name) and !empty($email) and !empty($phone) and !empty($address) and !isset($_SESSION['error']))
    {
        if($minimarket->SearchUserInformationById($_SESSION['loggedUser']['user_id']))
            $id = $minimarket->updateUserInformation($_SESSION['loggedUser']['user_id'],$surname, $name, $patronymic, $phone, $address);
        else
            $id = $minimarket->addUserInformation($_SESSION['loggedUser']['user_id'],$surname, $name, $patronymic, $phone, $address);
    }
    else if (!isset($_SESSION['error']))    
        $_SESSION['error']='Укажите все параметры';
    if(isset($email) && !isset($_SESSION['error']))
    {   $user = $minimarket->searchUserByEmail($email);
        if(isset($user))
        {   if($user['user_id']!=$_SESSION['loggedUser']['user_id'])
                $_SESSION['error']="Пользователь с указанным email уже зарегистрирован";
        }
        else if($email!=$_SESSION['loggedUser']['email'])
            if(!$minimarket->updateUser($_SESSION['loggedUser']['user_id'], $email, 'email'))
                $_SESSION['error']="Возникла ошибка при изменении email";
            else
                $_SESSION['loggedUser']['email']=$email;
    }
    if((isset($_SESSION['error']))||(!$id))                   //если есть ошибки
        {   $_SESSION['data']=$_POST;
            header("Location: index.php?id=personal");
        }
    else                                                //если всё ок
        {   $_SESSION['error']='Ваши данные успешно сохранены';
            header("Location: index.php?id=personal");
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