<link rel="stylesheet" href="../inc/style.css">
<script src="../nicEdit/nicEdit.js" type="text/javascript"></script> 
<script type="text/javascript"> ; //подключаем визуальный редактор текста 
bkLib.onDomLoaded(function() {nicEditors.allTextAreas(({maxHeight : 150, buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','forecolor','bgcolor','hr','subscript','superscript','removeformat'] }))}); 
 //устанавливаем, какие кнопки визуального редактора нам нужны </script>  
 <br>
<?php
    require_once "../inc/class.inc.php"; 
    require_once "secure.inc.php";
    if(isset($_GET['firstitem']))
        $products = $minimarket->selectFirstNProducts($_GET['firstitem'],10);
    else
        $products = $minimarket->selectFirstNProducts(0,10);
    
    foreach($products as $item)
    {
        //$description = strip_tags($item['description'], '<b><em><u><i><li><ol>');
        ?>
        <form enctype="multipart/form-data" action="editingProducts.php?updatingId=<?=$item['id']?>" method="POST"> 
        Название товара:
        <input type="text" id="editProductName" name="name" placeholder="Название товара" required value='<?=$item['name']?>'>
    <div id="ImageBlock">
            <img src="../images/showImage.php?product_id=<?=$item['id']?>"> 
    </div>
    <div id="editDescription">
        <div id="descr">
        <textarea rows="5" cols="100" name="description" required> <?=$item['description']?></textarea>
        </div> 
    </div>
    <div id="underDescription">
        <div id="leftUnder">
            <div id="available">
            <p><input   name="available" type="radio" value=1 <?=($item['available'])? 'checked': ''?>> Есть в наличии</p>  
            <p><input   name="available" type="radio" value=0 <?=($item['available'])? '': 'checked'?> > Нет в наличии</p>    
            </div>
        </div>
        <div id="rightUnder"> 
        Цена:
            <input type="number" name="price" placeholder="Цена" value=<?=$item['price']?>>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />  
		<p>Изображение: <input type="file" name="image" />
        <button type="submit">Изменить</button>
        </form>
        </div>
    </div>
    
<?php } ?>
<center><div id="pageNumber">
<?php 
$k = $minimarket->countProducts(); //общее количество товаров
$k=ceil($k/10); //k - требуемое количество страниц
for($i=0;$i<$k;$i++)
{
    $pageNumber=$i+1;
    $bdpagenumber=$i*10;
    //if($_GET['firstitem']==++$i)
         //echo "<style> text-decoration: none;</style>";
    echo '<a href='."admin.php?id=editproducts&firstitem=$bdpagenumber".">{$pageNumber}</a> &nbsp &nbsp &nbsp";
}
?>
    </div>
</center><br><br><br> 