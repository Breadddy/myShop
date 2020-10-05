<?php 
if($_SESSION['loggedUser']['login']=='admin')
    header("Location: index.php");
else
    header("Location: index.php?id={$_GET['ref']}");    //перенаправляем
unset($_SESSION['loggedUser']);
