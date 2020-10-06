<?php
require_once "secure.inc.php";
require_once "../inc/class.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$name = $minimarket->clearString($_POST['name']);
$description = $_POST['description'];
$price = (int)$_POST['price'];
$available = (int)$_POST['available'];
$id=$_GET['updatingId'];
if($minimarket->updateProduct($name, $description, $price, $available, $id))
if(isset($_FILES['image']))
    $minimarket->receiveImage2($id);
header("Location: {$_SERVER['HTTP_REFERER']}");
}