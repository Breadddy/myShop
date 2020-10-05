<?php require "secure.inc.php";?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Добавление товаров в магазин</title>
</head>
<body>
	<h1>Добавление нового товара в магазин</h1> 
	<form enctype="multipart/form-data" action="addingProducts.php" method="post">
		<p>Название товара: <input type="text" name="name" size="50" />
		<script src="../nicEdit/nicEdit.js" type="text/javascript"></script> 
<script type="text/javascript"> ; //подключаем визуальный редактор текста 
bkLib.onDomLoaded(function() {nicEditors.allTextAreas(({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','forecolor','bgcolor','hr','subscript','superscript','removeformat'] }))}); 
 //устанавливаем, какие кнопки визуального редактора нам нужны </script>  
        <p>Описание: <textarea rows="10" cols="100" name="description"></textarea>
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />  
		<p>Изображение: <input type="file" name="image" />
		<p>Цена: <input type="number" name="price" 
                        size="100" />
        <p>Есть ли товар на складе? 
    					<p><input name="available" type="radio" value=1> Есть в наличии</p>  
						<p><input name="available" type="radio" value=0> Нет в наличии</p>         
		<p><input type="submit" value="Добавить товар" />
	</form>
</body>
</html>