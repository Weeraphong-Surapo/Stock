<?php
    include('../config/connect.php');
    $sql = "SELECT * FROM `tb_sale_product`";
    $query = $con->query($sql);
    $row = $query->fetch_all();
    $data = array();
    foreach($query as $row){
        array_push($data,$row);
    }
    echo json_encode($data);
?>