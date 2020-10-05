<head> <title> Регистрация </title> </head>
<div id="signUp">
<?php 
if (isset($_SESSION['loggedUser'])) 
	goto LoggedIn;
if(isset($_SESSION['error']))
{	echo '<h3>'.$_SESSION['error'].'</h3>';	
	unset($_SESSION['error']);
}	?>

<form action="login/signingUp.php" method="POST"> <br>
	<p>
	<input type="text" name="login" maxlength=25 placeholder="Логин" pattern="([A-Za-z0-9-]+)" title='Логин не должен содержать русских букв и пробелов' value="<?=$_SESSION['data']['login']?>" autofocus> <br>
	<input type="email" name="email" maxlength=25 placeholder="Email" value="<?=$_SESSION['data']['email']?>"> <br>
	<input type="password" name="password" maxlength=25 placeholder="Пароль"/ required> <br>
	<input type="password" name="password2" maxlength=25 placeholder="Пароль ещё раз"/ required> <br>
	<button type="submit"  name="do_signup">Зарегистрироваться</button> <br>
	<input type="hidden" name="referer" value=<?=$_SERVER["HTTP_REFERER"]?>>
	</p>
</form>
</div>
<?php LoggedIn: 
if (isset($_SESSION['loggedUser'])) 
	echo 'Вы вошли под логином '.$_SESSION['loggedUser']['login'];
unset($_SESSION['data']);