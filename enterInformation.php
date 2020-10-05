<?php 
//echo $_SESSION['loggedUser']['user_id'];
$id = strtolower(strip_tags(trim($_GET['id'])));
if(($id=='createorder')&&(($_POST['createOrder']=='pushed')||(isset($_SESSION['error']))))
{
    $entering='Чтобы принять заказ, нам необходимо кое-что узнать о вас. Всё, что вы нам сообщите, останется только между нами.';
    $header2='Подробности доставки'; 
    $buttonName='Оформить заказ';
}
else if($id=='personal')
{
    if(!isset($_SESSION['loggedUser']))
    {
        echo "<h1>Вы не вошли в аккаунт</h1>";
        echo "<h3><a href='../index.php?id=login'>Войти в аккаунт</a><br>";
        echo "<a href='../index.php?id=signup'>Регистрация</a><br>";
        goto end;
    }
    $entering='Если вы сейчас введёте эти данные, то вам не придется заниматься этим в дальнейшем при оформлении заказов';
    $header2='О месте доставки';  
    $buttonName='Сохранить';
}
else
    {
        header("Location: ../index.php?id=catalog");    
        exit();
    }
echo '<link rel="stylesheet" type="text/css" href="inc/style.css" />';
?>

<p id="enteringOrder"><?=$entering?></p>
<?php 
if(isset($_SESSION['error']))
    {   echo "<h2>{$_SESSION['error']}</h2>";
        unset($_SESSION['error']);
    }
if($id=='createorder')
    echo '<form action="creatingOrder.php" method="POST">';
else if(($id=='personal'))
    echo '<form action="enteringInformation.php" method="POST">';
if(isset($_SESSION['data']))
    $data=$_SESSION['data'];
else
    $data=$minimarket->SearchUserInformationById($_SESSION['loggedUser']['user_id'])
?>
	<h1 id="orderheader">О вас</h1>
    <span id="inputNames">
        Фамилия: <br>
        Имя: <br>
        Отчество:<br>
        Email: <br>
        Телефон: 
        <h6>В любом формате
            </h6>
    </span>
    <div id="orderInputs">
        <input type="text" name="surname" pattern="^[А-Яа-яЁё\s]+$" value="<?=$data['surname']?>"required autofocus> <br> 
        <input type="text" name="name" pattern="^[А-Яа-яЁё\s]+$" value="<?=$data['name']?>" required > <br>
        <input type="text" name="patronymic" pattern="^[А-Яа-яЁё\s]+$"placeholder="(необязательно)" value="<?=$data['patronymic']?>" > <br>
        <input type="email" name="email" required value="<?=isset($_SESSION['data']['email'])?$_SESSION['data']['email']:$_SESSION['loggedUser']['email']?>"> <br> 
        <input type="tel" name="phone" placeholder="телефон" 
                required 
                value="<?=$data['phone']?>"> <br><?//pattern="[?/+\d]{10,12}"?>  
                Например, +79175207752 
    </div>
    <h1 id="orderheader"><?=$header2?></h1>
  <?php if(isset($_SESSION['data']))
            {   $data1=$minimarket->SearchUserInformationById($_SESSION['loggedUser']['user_id']);
                $address=$data1['address'];
            }
        else
            $address=$data['address'];
        if($address)    {?>
    <div id="Savedaddress">
        <h3>Ваш сохранённый адрес: <?=$address?></h3>
        Если хотите изменить его, введите новый адрес в форму ниже
    </div><?php }?>
    <?php if($id=='personal')
                echo '<span id="personalInputNames2">';
            else    
                echo '<span id="inputNames2">' ?>
        Улица: <br>
        Дом: <br>
        Квартира:<br>
        <?php if($id=='createorder'){?>
            <h6>Удобная дата доставки: </h6>
            <h6>Хотите поболтать с менеджером о заказе?</h6><br>
        <?php }?>
    </span>
    <?php if($id=='personal')
                echo '<div id="personalOrderInputs2">';
            else    
                echo '<div id="orderInputs2">' ?>
    
        <input type="text" name="street" pattern="^[А-Яа-яЁё\s\d]+$" value="<?=$_SESSION['data']['street']?>" <?=($id=='createOrder' && !$address)?'required':''?>> <br> 
        <input type="text" name="house" pattern="^[А-Яа-яЁё\s\d]+$" value="<?=$_SESSION['data']['house']?>" <?=($id=='createOrder' && !$address)?'required':''?> > <br>
        <input type="text" name="flat" pattern="^[А-Яа-яЁё\s\d]+$" value="<?=$_SESSION['data']['flat']?>"> <br>
        <input name="savedAddress" type="hidden" value="<?=$address?>"> 
        <?php if($id=='createorder'){?>
            <input type="date" name="time" min="<?=strftime("%F",time())?>" max="<?=strftime("%F",time()+604800)?>" value="<?=$_SESSION['data']['time']?>"required > <br> <br> <br>
            <input name="WantTalking" value=1 type="radio" required <?=($_SESSION['data']['WantTalking'])?'checked':''?>> Да<br>
            <input name="WantTalking" value=0 type="radio" required <?=($_SESSION['data']['WantTalking'])?'':'checked'?>> Нет 
        <?php }?>
    </div>
	<button id="createOrder" type="submit"><?=$buttonName?></button> <br>
</form>
<?php if($id=='personal'){?>
    <form action="login/changePassword.php" method="POST">
            <h1>Смена пароля </h1>
            <span id="personalInputNames2">
                <h6>Старый пароль: <br></h6>
                <h6>Новый пароль:  <br></h6>
                <h6>Новый пароль:  </h6>
            </span>
            <span id="personalOrderInputs2">
                <input type="password" name="oldPassword" required> <br>
                <input type="password" name="newPassword" required> <br>
                <input type="password" name="newPassword2" required> <br>
            </span>
            <button id="createOrder" type="submit">Сменить пароль</button> <br><br><br><br><br>
        <?php }?>
<?php unset($_SESSION['data']);
end: ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>     <!-- выбиральщик даты -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
  webshims.setOptions('waitReady', false);
  webshims.setOptions('forms-ext', {type: 'date'});
  webshims.setOptions('forms-ext', {type: 'time'});
  webshims.polyfill('forms forms-ext');
</script>