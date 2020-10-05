<?php 
require_once "../inc/class.inc.php"; 

header("Content-type: image/jpeg"); 
echo $minimarket->selectImages($_GET['product_id']);

