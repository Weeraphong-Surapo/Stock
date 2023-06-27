
<?php 
session_start();
// require 'vendor/autoload.php';


if(!isset($_SESSION['login'])){
	echo '<script>location.href="login.php"</script>';
}
include('config/connect.php');
include('function/head.php');

if(isset($_GET['p']) && $_GET['p'] != 'salepic' && $_GET['p'] != 'salelist' &&  $_GET['p'] != 'salereport' && $_GET['p'] != 'salecustomerreport' && $_GET['p'] != 'returnreport' && $_GET['p'] != 'supplierreport' && $_GET['p'] != 'salesumaryreport' && $_GET['p'] != 'mycustomer' && $_GET['p'] != 'contactlist' && $_GET['p'] != 'setting-coupon' && $_GET['p'] != 'customergroup' && $_GET['p'] != 'customerlevel' && $_GET['p'] != 'customersex' && $_GET['p'] != 'storyByCustomer'){
	include('function/sidebar.php');
}else if(isset($_GET['p']) && $_GET['p'] != 'salelist' && $_GET['p'] != 'salereport' && $_GET['p'] != 'salecustomerreport' && $_GET['p'] != 'returnreport' && $_GET['p'] != 'supplierreport' 
&& $_GET['p'] != 'salesumaryreport' && $_GET['p'] != 'salepic' && $_GET['p'] != 'salelist' &&  $_GET['p'] != 'salereport' && $_GET['p'] != 'salecustomerreport' && $_GET['p'] != 'returnreport' 
&& $_GET['p'] != 'supplierreport' && $_GET['p'] != 'salesumaryreport'  && $_GET['p'] != 'setting-coupon'){
	include('function/sidebarCustomer.php');
}
else if(isset($_GET['p']) && $_GET['p'] == 'setting-coupon'){
	include('function/sidebarCoupon.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'salelist' || $_GET['p'] == 'salereport' || $_GET['p'] == 'salecustomerreport' || $_GET['p'] == 'returnreport' || $_GET['p'] == 'supplierreport' || $_GET['p'] == 'salesumaryreport'){
	include('function/sidebarSaleList.php');
}

include('function/navbar.php');


if(!isset($_GET['p']) || $_GET['p'] == 'home'){
	require('select.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'stock'){
	require('stock/stock.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'importproduct'){
	require('stock/importproduct.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'productlist'){
	require('stock/productlist.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'productcategory'){
	require('stock/productcategory.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'supplier'){
	require('stock/supplier.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'counting'){
	require('stock/counting.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'salepic'){
	require('salepic/salepic.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'salelist'){
	require('salelist/salelist.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'datatable'){
	require('datatable.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'mycustomer'){
	require('mycustomer/mycustomer.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'contactlist'){
	require('mycustomer/contactlist.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'setting-coupon'){
	require('setting-coupon.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'salesumaryreport'){
	require('salelist/salesumaryreport.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'salereport'){
	require('salelist/salereport.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'customergroup'){
	require('mycustomer/customergroup.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'customerlevel'){
	require('mycustomer/customerlevel.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'customersex'){
	require('mycustomer/customersex.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'borrow'){
	require('stock/borrow.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'supplierreport'){
	require('salelist/supplierreport.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'storyByCustomer'){
	require('mycustomer/storyByCustomer.php');
}else if(isset($_GET['p']) && $_GET['p'] == 'productsubcategory'){
	require('stock/productsubcategory.php');
}













include('function/footer.php'); ?>

