<?php 
include('../config/connect.php');
  $res = json_decode(file_get_contents("php://input"));
  $data = array();

  if($res->action == "getAllProduct"){
    $sql = "SELECT * FROM `tb_productlist`";
    $query = $con->query($sql);
    foreach($query as $row){
        $data[] = $row;
    }
    echo json_encode($data);
  }

  if($res->action == "getAllCategory"){
    $sql = "SELECT * FROM tb_categorie";
    $query = $con->query($sql);
    foreach($query as $row){
      $data[] = $row;
    }
    echo json_encode($data);
  }

  if($res->action == "SaleProduct"){
    $code_sale = $con->query("SELECT * FROM tb_sale_product");
    $count_code_sale = $code_sale->num_rows;
    date_default_timezone_set('Asia/Bangkok');
    $date = date("d/m/Y H:i");
    if($count_code_sale < 0){
      $count_code_sale = 1;
    }else{
      $count_code_sale = $code_sale->num_rows;
    }
    

    $total_price = 0;
    foreach($res->Cart as $k => $v){
      $count_sale += $v->qty;
      $total_price += $v->pl_selling_price * $v->qty;
    }

    $changeMo = $res->getMo - $res->totelPriceVat;

    $sql = "INSERT INTO tb_sale_product(
      `customer_id`,`order_code`, `sp_qty_sale`, `sp_sell`, `vat`, `total_sum_vat`, `get_money`, `change_money`,`sell_date`) VALUES(
        '$res->Cus_id','$count_code_sale','$count_sale','$total_price','$res->vatproduct','$res->totelPriceVat','$res->getMo','$changeMo','$date'
      )";

    $query_sale = $con->query($sql);
    $sp_id = $con->insert_id;
    foreach($res->Cart as $k => $v){
      $price_product = $v->pl_selling_price * $v->qty;
      $cost = $v->pl_cost * $v->qty;
      $discount = $v->pl_discount * $v->qty;
      $sum_total_discount = $price_product - $discount;
      $con->query("INSERT INTO `tb_order_product`(`product_id`,`sp_id`,`qty`,`total_price`,`discount`,`sum_total_discount`,`cost`) VALUES ('$v->id','$sp_id','$v->qty','$price_product','$discount','$sum_total_discount','$cost')");
      
      foreach ($res->Cart as $k => $v) {
        $sql3 = "SELECT * FROM tb_productlist where id = '$v->id'";
        $query3 = $con->query($sql3);
        $row3 = $query3->fetch_array();
        $count = $query3->num_rows;


        //ตัดสต๊อก
        for ($i = 0; $i < $count; $i++) {
            $have =  $row3['pl_quantity'];

            $stc = $have - $v->qty;

            $sql9 = "UPDATE tb_productlist SET pl_quantity = $stc WHERE id = '$v->id' ";
            $con->query($sql9);
        }

        /*   stock  */
    }
    }
    $customer = $con->query("SELECT * FROM tb_customer WHERE cus_id = '$res->Cus_id'");
    if($customer->num_rows >= 1){
      $row_custoemr = $customer->fetch_array();
      $name = $row_custoemr['cus_name'];
    }else{
      $name = "";
    }

    $data = array(
      "sp_id"=>$sp_id,
      "id"=>$sp_id,
      "code"=>$count_code_sale,
      "name"=>$name,
      "lastname"=>$row_custoemr['cus_lastname'],
      "qty"=>$count_sale,"total"=>$total_price,
      "vat"=>$res->vatproduct,"vat_total_price"=>$res->totelPriceVat,
      "getMoney"=>$res->getMo,
      "changeMoney"=>$changeMo,
      "time"=>$date,
    );
    echo json_encode($data);
  }

  if($res->action == "getAllSaleDay"){
    $sql = "SELECT * FROM tb_sale_product";
    $query = $con->query($sql);
    foreach($query as $row){
      $customer = $con->query("SELECT * FROM tb_customer WHERE cus_id = '$row[customer_id]'");
      $row_custoemr = $customer->fetch_array();
      array_push($data,array(
        "sp_id"=>$row['sp_id'],
        "customer"=>$row_custoemr['cus_name']." ".$row_custoemr['cus_lastname'],
        "order_code"=>$row['order_code'],
        "sp_qty_sale"=>$row['sp_qty_sale'],
        "sp_sell"=>$row['sp_sell'],
        "vat"=>$row['vat'],
        "total_sum_vat"=>$row['total_sum_vat'],
        "get_money"=>$row['get_money'],
        "change_money"=>$row['change_money'],
        "sell_date"=>$row['sell_date'],
      ));
     
    }
    echo json_encode($data);
  }

  if($res->action == 'getAllCustomer'){
    $sql = "SELECT * FROM tb_customer";
    $query = $con->query($sql);
    foreach($query as $row){
      $province = $con->query("SELECT * FROM provinces WHERE code = '$row[cus_province]'");
      $row_province = $province->fetch_array();
      $amphures = $con->query("SELECT * FROM amphures WHERE code = '$row[cus_amphoe]'");
      $row_amphures = $amphures->fetch_array();
      $amphures = $con->query("SELECT * FROM amphures WHERE code = '$row[cus_amphures]'");
      $row_amphures = $amphures->fetch_array();

      $customer = array(
        "cus_id"=>$row['cus_id'],
        "cus_address"=>$row['cus_address'],
        "cus_province"=>$row_province['name_th'],
        "cus_amphures"=>$row_amphures['name_th'],
        "code_customer"=>$row['code_customer'],
        "cus_name"=>$row['cus_name'],
        "cus_lastname"=>$row['cus_lastname'],
        "cus_phone"=>$row['cus_phone']
      );
      array_push($data,$customer);
    }
    echo json_encode($data);
  }
