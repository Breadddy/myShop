<link rel="stylesheet" href="inc/style.css">
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
</head>
<?php
    //require_once "./inc/class.inc.php"; 
    include 'addingToBasket.js';
    if(isset($_GET['firstitem']))
        $products = $minimarket->selectFirstNProducts($_GET['firstitem'],10);
    else
        $products = $minimarket->selectFirstNProducts(0,10);
    $k = $minimarket->countProducts(); //общее количество товаров
    foreach($products as $item)
    {
/*         //echo 'символов описания:'.mb_strlen($item['description']);
        $length = mb_strlen($item['description']);
        $maxLength = 800;  //установка максимальной длины описания
        if($length>$maxLength) 
            {   $r = $maxLength - $length;
                $description = mb_strimwidth($item['description'], 0, $r, "...");
            }
        else
        $description = strip_tags($item['description'], '<b><em><u><i><li><ol>'); //разрешенные тэги  */
        ?>
       <h1><?=$item['name']?> <br></h1>
    <div id="ImageBlock">
            <img src="images/showImage.php?product_id=<?=$item['id']?>"> 
    </div>
    <div id="description">
            <p id="descr"><?=$item['description']?></p>  
    </div> 
    <div id="underDescription">
        <div id="leftUnder">
                <div id="available"><?=($item['available']) ? "Есть в наличии" : "Нет в наличии"?> </div>   
                <div id="price"> <?=$item['price']?> р.</div>
        </div>
        <div id="rightUnder"> 
    <form class="addingToBasket" method="POST"> 
        <input type="hidden" name=productId value=<?=$item['id']?>>
        <button type="submit">Добавить в корзину</button>
    </form>
        </div>
    </div>
 <?php }?>
<div id="pageNumber">
<?php 
$k=ceil($k/10); //k - требуемое количество страниц
for($i=0;$i<$k;$i++)
{
    $pageNumber=$i+1;
    $bdpagenumber=$i*10;
    echo '<a href='."index.php?id=catalog&firstitem=$bdpagenumber".">{$pageNumber}</a>";
}
?>
    </div>
<br><br><br>




    