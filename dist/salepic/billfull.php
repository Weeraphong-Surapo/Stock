<?php
include('../config/connect.php');
require_once __DIR__ . '/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);
$id = $_GET['p'];
date_default_timezone_set('Asia/Bangkok');
$date = date('d/m/Y H:i:s');
$sql = "SELECT * FROM tb_order_product WHERE sp_id = '$id'";
$query = $con->query($sql);
$sql_sale = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$id'");
$row_sale = $sql_sale->fetch_array();
$outp = '';
$detail = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$id'");
$rows = $detail->fetch_array();
$sql = "SELECT * FROM tb_order_product WHERE sp_id = '$id'";
$query = $con->query($sql);
$customer = $con->query("SELECT * FROM tb_customer WHERE cus_id = '$rows[customer_id]'");
if($customer->num_rows >=1){
    $row_customer = $customer->fetch_array();
    $jangwat = $con->query("SELECT name_th FROM provinces WHERE id = '$row_customer[cus_province]'");
    $amphoe = $con->query("SELECT name_th FROM amphures WHERE id = '$row_customer[cus_amphoe]'");
    $tambon = $con->query("SELECT name_th FROM districts WHERE id = '$row_customer[cus_tambon]'");
    $fulladdress = "ต.".$tambon->fetch_array()['name_th']." อ.".$amphoe->fetch_array()['name_th']." จ.".$jangwat->fetch_array()['name_th'];
    $name =$row_customer['cus_name'];
    $lastname =$row_customer['cus_lastname'];
    $address = $row_customer['cus_address']." ".$fulladdress;
}else{
    $name = '';
    $lastname = '';
    $address = '';
}
$i = 1;
$outp = '
<style>
table{
    width:100%;
}
</style>
<h3 style="margin-bottom:-5px;">เอก โมบาย (Airport เชียงใหม่)</h3>
<span>รหัสรายการ: '.$rows['order_code'].' ,ชื่อลูกค้า: '. $name.$lastname.', ที่อยู่: '.$address.'</span>
<div class="table-responsive"><table class="table table-bordered">
            <tr>
                <th style="border:1px solid black; padding:5px; text-align:center;">ลำดับ</th>
                <th  style="border:1px solid black; padding:5px; text-align:center;">ชื่อสินค้า</th>
                <th  style="border:1px solid black; padding:5px; text-align:center;">รหัสสินค้า</th>
                <th  style="border:1px solid black; padding:5px; text-align:right;">ราคาขาย/บาท</th>
                <th  style="border:1px solid black; padding:5px; text-align:right;">ส่วนลดต่อหน่วย/บาท</th>
                <th  style="border:1px solid black; padding:5px; text-align:right;">จำนวน</th>
                <th  style="border:1px solid black; padding:5px; text-align:right;">ราคารวม/บาท</th>
            </tr>';
foreach ($query as $row) {
    $product = $con->query("SELECT * FROM tb_productlist WHERE id = '$row[product_id]'");
    $row_product = $product->fetch_array();
    $total += $row_product['pl_selling_price'] * $row['qty'];
    $total_qty += $row['qty'];
    $outp .= '
                <tr>
                    <td  style="border:1px solid black; padding:5px;">' . $i++ . '</td>
                    <td  style="border:1px solid black; padding:5px;">' . $row_product['pl_name_product'] . '</td>
                    <td  style="border:1px solid black; padding:5px;">' . $row_product['pl_product_id'] . '</td>
                    <td style="text-align:right; border:1px solid black; padding:5px;">' . number_format($row_product['pl_selling_price'],'2') . '</td>
                    <td style="text-align:right; border:1px solid black; padding:5px;">'.number_format($row['pl_discount'],'2').'</td>
                    <td style="text-align:right; border:1px solid black; padding:5px;">' . $row['qty'] . '</td>
                    <td style="text-align:right; border:1px solid black; padding:5px;">' . number_format($rows['sp_sell'],'2') . '</td>
                </tr>';
}
$outp .= '<tr style="text-align:right;">
            <td style="border:1px solid black; padding:5px; text-align:right;" colspan="5"><b>รวม</b></td>
            <td style="border:1px solid black; padding:5px; text-align:right;"><b>' . number_format($total_qty) . '</b></td>
            <td style="border:1px solid black; padding:5px; text-align:right; fontsize:20px;"><u><b>' . number_format($total,'2') . '</b></u></td>
        </tr>';
$outp .= '<tr>
            <td style="text-align:right; border:1px solid black; padding:5px;" colspan="6">รับเงิน</td>
            <td style="text-align:right; border:1px solid black; padding:5px;"><b>' . number_format($rows['get_money'],'2') . '</b></td>
        </tr>
        <tr>
            <td style="text-align:right; border:1px solid black; padding:5px;" colspan="6">ทอนเงิน</td>
            <td style="text-align:right; border:1px solid black; padding:5px;"><b>' . number_format($rows['change_money'],'2') . '</b></td>
        </tr>';
$outp .= '</table></div>';
// echo $outp;
$mpdf->WriteHTML($outp);
$mpdf->Output();
?>






<script src="vue/salepic.js"></script>