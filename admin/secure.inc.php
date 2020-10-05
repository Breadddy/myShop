<?php 
    session_start(); 
    if(isset($_SESSION['loggedUser']))
        if($_SESSION['loggedUser']['login']=='admin')
            {   //header("Location: {$_SERVER['REQUEST_URI']}");
                //exit();
            }
        else
        {   echo "Вы вошли как {$_SESSION['loggedUser']['login']}. Ваша учётная запись не обладает правами администратора.<br>";
            echo "<a href='../index.php?id=logout'>Выйти и войти нормально</a><br>";
            exit();
        }
    else
    {
        echo "Вы не вошли в аккаунт администратора<br>";
        echo "<a href='../index.php?id=login'>Войти в аккаунт</a><br>";
        exit();
    }
