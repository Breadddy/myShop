<?php 
    require "secure.inc.php";
    require_once "../inc/class.inc.php"; 
	if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $name = $minimarket->clearString($_POST['name']);
            $description = $_POST['description'];
            //$image = $minimarket->receiveImage();
            $price = (int)$_POST['price'];
            $available = (int)$_POST['available'];
            if($id = $minimarket->addProduct($name, $description, $price, $available)) //если успешно добавилось
	            {   $minimarket->receiveImage2($id);
                    header("Location: admin.php?id=addproducts");
                }                                 
        }
    
        