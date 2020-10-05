<?php	
require_once "../inc/class.inc.php"; 
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user['login']=$minimarket->clearString($_POST['login']); //получаем данные
    $user['password']=$minimarket->clearString($_POST['password']);
    $user['password2']=$minimarket->clearString($_POST['password2']);
    $user['email']=$minimarket->clearString($_POST['email']);
    if(!($user['email']=filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)))
        $_SESSION['error']="Указанный вами адрес email не может существовать в соответствии с RFC 822";
    else if($user['password2']!= $user['password']) //проверка совпадения паролей
        $_SESSION['error']='Пароли не совпадают';
    else if ($minimarket->FieldExists($user['login'], 'login')) //проверка, нет ли пользователя с таким логином
        $_SESSION['error']= "Мы уже знакомы с {$user['login']}. Советую вам придумать другой логин";
    else if ($minimarket->FieldExists($user['email'], 'email')) //проверка, нет ли пользователя с таким email
        $_SESSION['error']='Когда-то в незапямятные времена(а может и вчера) кто-то уже зарегистрировался с таким Email';
    else
    {	
        $user['password']=password_hash($user['password'], PASSWORD_BCRYPT); //  хэшируем пароль
        if($id=$minimarket->addUser($user['login'], $user['email'], $user['password']))
            {   
                $user['user_id']=$id;
                unset($user['password2']);
                $_SESSION['loggedUser'] = $user; 
                header("Location: {$_POST['referer']}");    //перенаправляем
                exit();
            }          
    } 
}
$_SESSION['data']=$_POST;
header("Location: ../index.php?id=signup");    //перенаправляем
?>