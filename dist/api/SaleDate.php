<?php
    include('../config/connect.php');
    $sql = "SELECT * FROM `tb_sale_product`";
    $query = $con->query($sql);
    $rows = $query->fetch_array();
    $customer = $con->query("SELECT * FROM tb_customer WHERE cus_id = '$rows[customer_id]'");
    $row_custoemr = $customer->fetch_array();
    $data = array();
    $date = date('d/m/Y');


        foreach($query as $row){
            $date_x = explode(" ",$row['sell_date']);
            if($date_x[0] == $date){

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
    }
    echo json_encode($data);
