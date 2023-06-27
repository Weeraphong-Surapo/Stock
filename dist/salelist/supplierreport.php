<?php
$all_product = $con->query("SELECT * FROM tb_productlist");
$array = array();
foreach ($all_product as $row) {
    $name = $row['pl_name_product'];
    array_push($array, $name);
}

$array_price = array();
$price = 0;

// print_r($array_qty);
?>
<div class="portlet-body">
    <div id="apexchart-4"></div>
</div>
<div class="portlet-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataAllProduct">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนการขาย</th>
                    <th>ขายใด้/บาท</th>
                    <th>ส่วนลด/บาท</th>
                    <th>รายรับ/บาท</th>
                    <th>ต้นทุน/บาท</th>
                    <th>กำไร/ขาดทุน</th>
                    <th>ROI</th>
                </tr>
            </thead>
            <?php 
            $i =1;
            $all_supplier = $con->query("SELECT * FROM tb_productlist");
            foreach($all_supplier as $row):
                $supplier = $con->query("SELECT * FROM tb_supplier WHERE sup_id = '$row[s_id]'");
                $row_supplier = $supplier->fetch_array();
                $sum_price = $con->query("SELECT sum(total_price) as total_prices FROM tb_order_product WHERE product_id = '$row[id]'");
                $total_price = $sum_price->fetch_array();
                $check = $con->query("SELECT count(order_id) as qty FROM tb_order_product WHERE product_id = '$row[id]'");
                $discount = 0;
                if ($check->num_rows >= 1) {
                    $count_qty = $check->fetch_array();
                    $discount = $con->query("SELECT qty,discount,sum_total_discount,cost FROM tb_order_product WHERE product_id = '$row[id]'");
                    $r_discount = $discount->fetch_array();
                    if($discount->num_rows >=1){
                        $sum_qty = $con->query("SELECT sum(qty) as sum_qty FROM tb_order_product WHERE product_id = '$row[id]'");
                        $row_sum_qty = $sum_qty->fetch_array();
                        $qty = $row_sum_qty['sum_qty'];
                        $discount = $r_discount['discount'];
                        $sum_cost = $r_discount['cost'];
                        $sum_total = $r_discount['sum_total_discount'];
                    }else{
                        $qty = 0;
                        $discount = 0 ;
                        $sum_cost = 0;
                        $sum_total= 0;
                    }
                    $cost = $con->query("SELECT sum(cost) as costs FROM tb_order_product WHERE product_id = '$row[id]'");
                    $r_cost = $cost->fetch_array();

    

                    $profix = $sum_total - $sum_cost;
                    if ($profix > 0 && $sum_cost > 0) {
                        $roi = ($profix / $sum_cost) *100 ;
                    } else {
                        $roi = 0;
                    }
                    array_push($array_price, $sum_total);
                } else {
                    $qty = 0;
                    $discount = 0;
                    $sum_cost = 0;
                    $sum_total = 0;
                    array_push($array_price, $sum_total);
                }
            ?>
            <tr>
                <td><?= $row_supplier['sup_name'];?></td>
                <td><?= $row['pl_product_id'];?></td>
                <td><?= $row['pl_name_product']?></td>
                <td><?= $qty; ?></td>
                <td><?= number_format($total_price['total_prices']); ?></td>
                <td><?= number_format($discount); ?></td>
                <td><?= number_format($sum_total); ?></td>
                <td><?= number_format($sum_cost); ?></td>
                <td><?= number_format($sum_total - $sum_cost ) ?></td>
                <td><?= number_format($roi, 2, '.', ',') ?> %</td>
            </tr>
            <?php endforeach;?>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>

    var table = $('#dataAllProduct').DataTable();
</script>