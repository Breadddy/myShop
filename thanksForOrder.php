<?php if(!isset($_SESSION['order_id']))
            goto end;?>
<div id="thanksForOrder">
    <img src="images/ThanksForOrder.png">
    <h1>Номер вашего заказа: 
    <?php echo $_SESSION['order_id'];
    unset($_SESSION['order_id']);
    ?>
    </h1>
</div>
<?php end:?>