<?php
require_once "../inc/class.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'POST')
	{	
        $login =  $minimarket->clearString($_POST['login']); // получаем введённые логин и пароль
        $password = $minimarket->clearString($_POST['password']);
        $user = $minimarket->searchUserByLogin($login);
		if ($user) //если пользователь найден
		{
			if(password_verify($password, $user['password'])) //проверяем, верно ли введён пароль
			{
				$user['login']=stripcslashes($user['login']);
				$_SESSION['loggedUser'] = $user;
				if($_SESSION['loggedUser']['login']=='admin')	//если залогинился админ
					header("Location:../admin/admin.php");
				else
					header("Location: {$_POST['referer']}");    //перенаправляем если залогинился пользователь
				exit();
			}
			else
				$GLOBALS['err']='Пароль введён неверно'; //бесполезное действие
		}
		else
		$GLOBALS['err']='<h3>Пользователя с таким логином не существует'; //бесполезное действие
	}
header("Location: ../index.php?id=login&fail=1");    //перенаправляем если ошибка
$_SESSION['enteredLogin']=$login;
