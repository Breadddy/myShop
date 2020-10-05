<?php
$id = strtolower(strip_tags(trim($_GET['id'])));
if($_SERVER["SCRIPT_NAME"]=="/admin/admin.php")
switch($id){
	case 'editproducts': include '../admin/editProducts.php'; break;
	case 'addproducts': include '../admin/addProducts.php'; break;
	case 'showorders': include '../admin/showOrders.php'; break;
}
else
switch($id){
	case 'paydeliver': include 'inc/payDeliver.inc.php'; break;
	case 'about': include 'inc/about.inc.php'; break;
	case 'catalog': include 'showCatalog.php'; break;
	case 'login': include 'login/logIn.php'; break;
	case 'signup': include 'login/signUp.php'; break;
	case 'logout': include 'login/logOut.php'; break;
	case 'basket': include 'showBasket.php'; break;
	case 'createorder': include 'enterInformation.php'; break;
	case 'thanksfororder': include 'thanksForOrder.php'; break;
	case 'personal': include 'inc/personal.inc.php'; break;
	default: include 'index.inc.php';
}	