<?php
require_once "../inc/class.inc.php";
if(isset($_SESSION['loggedUser'])){
    $oldPassword = $minimarket->clearstring($_POST['oldPassword']);
    $newPassword = $minimarket->clearstring($_POST['newPassword']);
    $newPassword2 = $minimarket->clearstring($_POST['newPassword2']);
    $user = $minimarket->searchUserByLogin($_SESSION['loggedUser']['login']);
    if(!password_verify($oldPassword, $user['password'])) //проверяем, верно ли введён старый пароль
        $_SESSION['error']="Старый пароль введён неверно";
    else if($newPassword!=$newPassword2)                    
        $_SESSION['error']="Новые пароли не совпадают";
    else
        {
            $newPassword=password_hash($newPassword, PASSWORD_BCRYPT); //  хэшируем пароль
            if($minimarket->updateUser($user['user_id'], $newPassword, 'password'))
                $_SESSION['error']="Пароль успешно изменён";
            else    
                $_SESSION['error']="Что-то пошло не так";
        }
    header("Location: ../index.php?id=personal");

}