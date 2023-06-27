<?php 
include('../config/connect.php');

if(isset($_POST['DeleteRowSaleList'])){
    $sql = "DELETE FROM tb_sale_product WHERE sp_id = '$_POST[id]'";
    $con->query($sql);
}

if(isset($_POST['ShowOrder'])){
    $detail = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$_POST[id]'");
    $rows = $detail->fetch_array();
    $sql = "SELECT * FROM tb_order_product WHERE sp_id = '$_POST[id]'";
    $query = $con->query($sql);
    $i = 1;
        $outp = '<table class="table table-bordered">
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อสินค้า</th>
            <th>รหัสสินค้า</th>
            <th>ราคาขาย/บาท</th>
            <th>ส่วนลดต่อหน่วย/บาท</th>
            <th>จำนวน</th>
            <th>ราคารวม/บาท</th>
        </tr>';
        foreach($query as $row){
            $product = $con->query("SELECT * FROM tb_productlist WHERE id = '$row[product_id]'");
            $row_product = $product->fetch_array();
            $total += $row_product['pl_price1'] * $row['qty'];
            $total_qty += $row['qty'];
        $outp .= '
            <tr>
                <td>'.$i++.'</td>
                <td>'.$row_product['pl_name_product'].'</td>
                <td>'.$row_product['pl_product_id'].'</td>
                <td style="text-align:right;">'.number_format($row_product['pl_price1']).'</td>
                <td style="text-align:right;">ส่วนลด</td>
                <td style="text-align:right;">'.$row['qty'].'</td>
                <td style="text-align:right;">'.number_format($rows['sp_sell']).'</td>
            </tr>';
    }
    $outp .= '<tr style="text-align:right;">
        <td colspan="5">รวม</td>
        <td>'.number_format($total_qty).'</td>
        <td>'.number_format($total).'</td>
    </tr>';
    $outp .= '<tr>
        <td style="text-align:right;" colspan="6">รับเงิน</td>
        <td style="text-align:right;">'.number_format($rows['get_money']).'</td>
    </tr>
    <tr>
        <td style="text-align:right;" colspan="6">ทอนเงิน</td>
        <td style="text-align:right;">'.number_format($rows['change_money']).'</td>
    </tr>';
    $outp .= '</table>';
    echo $outp;
}
