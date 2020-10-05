<head> <title> Вход </title> </head>
<?php 
//require_once "../inc/class.inc.php"; 
if (isset($_SESSION['loggedUser'])) 
		goto LoggedIn;
if($_GET['fail'])
	echo '<h3><center>Что-то не так. Может быть, вы ввели неверный пароль, забыли логин или выбрали не тот путь по жизни</h3></center>';
?>
<div id='logIn'>
<form action="login/loggingIn.php" method="POST"> <br>
	<p>
	<input type="text" name="login" pattern="([A-Za-z0-9-]+)"placeholder="Логин"/ required autofocus value=<?=$_SESSION['enteredLogin']?> > <br> 
	<input type="password" name="password" placeholder="Пароль"/ required> <br>
	<button type="submit" name="do_login">Войти</button> <br>
	<input type="hidden" name="referer" value=<?=$_SERVER["HTTP_REFERER"]?>>
	</p>
</form>
</div>
<?php 
unset($_SESSION['enteredLogin']);
LoggedIn: 
if (isset($_SESSION['loggedUser'])) 
	echo 'Вы вошли под логином '.$_SESSION['loggedUser']['login'];