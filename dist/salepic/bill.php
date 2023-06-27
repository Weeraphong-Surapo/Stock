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
        'format' => [80, 80]
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
$sale_product = $con->query("SELECT * FROM `tb_sale_product` WHERE sp_id = '$id'");
$row_sale_product = $sale_product->fetch_array();
$order_product = $con->query("SELECT * FROM tb_order_product WHERE sp_id = '$id'");


$outp = '';
$outp .= '<style>
table {
    border-collapse: collapse;
    width: 100%;
}

.main-cart {
    height: 400px;
}

.cc-box-cart {
    overflow-y: scroll;
    max-height: 300px;
    height: 100%;
}
</style>
<div style="display: flex; flex-direction: column; align-items: center;">
    <!-- <h3 style="padding: 0; margin: 0; text-align: center;">PORNCHAI SERVICE</h3> -->
    <h3 style="padding: 0; margin: 0; text-align: center;">xxxxxxxx xxxxxxx</h3>
    <h6 style="padding: 0; margin: 0; text-align: center;">TAX:</h6>
    <!-- <h6 style="padding: 0; margin: 0; text-align: center;">ราชบุรี</h6> -->
    <h6 style="padding: 0; margin: 0; text-align: center;">xxxxx</h6>
    <!-- <h6 style="padding: 0; margin: 0; text-align: center;">โทร: 090-526-6789 ช่างเอก</h6> -->
    <h6 style="padding: 0; margin: 0; text-align: center;">xxxx xxxxxxxxxxxx xxxxxx</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">(VAT Included)</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">สินค้า/บริการ</h6>
</div>
<div style="display: flex; justify-content: space-between;">
    <table style="width: 100%;">';

    foreach($order_product as $row):
        $proudct= $con->query("SELECT * FROM tb_productlist WHERE id = '$row[product_id]'");
        $row_product = $proudct->fetch_array();
        $total_price += $row_product['pl_selling_price'] * $row['qty'];

        $outp .= '<tr>
            <td>'.$row['qty'].' '.$row_product['pl_name_product'].'</td>
            <td style="text-align: right;">'.number_format($row_product['pl_selling_price']).'</td>
        </tr>';
    endforeach;


        $outp .= '<tr>
            <td>รวมเงิน</td>
            <td style="text-align: right;" id="sum">'.number_format($total_price).'</td>
        </tr>

        <tr>
            <td>รับเงิน</td>
            <td style="text-align: right;" id="get">'.number_format($row_sale_product['get_money']).'</td>
        </tr>

        <tr>
            <td>เงินทอน</td>
            <td style="text-align: right;" id="change">'.number_format($row_sale_product['change_money']).'</td>
        </tr>
    </table>
</div>
<br>
<div style="display: flex; flex-direction: column; align-items: center;">
    <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">พนักงานขาย: xxxxxxxxxxxxx</h6>
    <h6 style="padding: 0; margin: 0; text-align: center;">
        วันที่: <span id="date" class="ms-1"> '.$date.' น.</span>
    </h6> <br>
    <h6 style="padding: 0; margin: 0; text-align: center;">----------------------------------</h6>
</div>
';
$mpdf->WriteHTML($outp);
$mpdf->Output();
?>






<script src="vue/salepic.js"></script>



<script>
    // const pdf = (e) => {
    //     alert(e)
    // }

    // small bill
    let inputmoney = 0
    $('#enter').click(() => {
        inputmoney = $('#inputmoney').val()
        $('#getchange').text(parseFloat($('#getchange').text()).toFixed(2))
    })
    $('#showbill').click(() => {
        $('#sum').text((inputmoney - $('#getchange').text()).toFixed(2))
        $('#price').text((inputmoney - $('#getchange').text()).toFixed(2))
        $('#get').text((inputmoney - $('#getchange').text()).toFixed(2))
        changemoney()

        // current date
        let currentDate = new Date()
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();

        //  current time
        let hours = currentDate.getHours();
        let minutes = currentDate.getMinutes();
        let seconds = currentDate.getSeconds();
        let formattedDate = `${day < 10 ? '0' : ''}${day}/${month < 10 ? '0' : ''}${month}/${year} ${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
        $('#date').text(formattedDate)
    })
    const changemoney = () => $('#change').text(parseFloat($('#getchange').text()).toFixed(2))
</script>