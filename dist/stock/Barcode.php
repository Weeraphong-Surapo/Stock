<?php 
include('../config/connect.php');
require_once __DIR__ . '/vendor/autoload.php';

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();

$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun'
]);

$product_id = $_GET['id'];
$date = date('d/m/y H:i');

$sql = "SELECT * FROM tb_productlist WHERE id = '$product_id'";
$query = $con->query($sql);
$row = $query->fetch_array();
$outp = '';
$outp .= '
<style>
    table{
    width:100%;
    }
    .box{
        padding:2px;
        border:1px dashed black;
    }
    img{
        margin:5px 0;
    }
</style>
<table>
<tr>
<td>'.$date.'</td>
<td>'.$row['pl_name_product'].'</td>
</tr>
</table>
<table>';
for($i=1;$i<12;$i++){
$outp .= '<tr>
    <td class="box">
    <center>
        <div>
            '.$row['pl_name_product'].'<br>
            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row["pl_product_id"], $generator::TYPE_CODE_128)) . '"><br>
            '.number_format($row['pl_selling_price']).' บาท
        </div>
        </center>
    </td>
    <td class="box">
    <center>
        <div>
            '.$row['pl_name_product'].'<br>
            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row["pl_product_id"], $generator::TYPE_CODE_128)) . '"><br>
            '.$row['pl_selling_price'].' บาท
        </div>
        </center>
    </td>
</tr>';
}
$outp .= '</table>';

// echo $outp;
$mpdf->WriteHTML($outp);
$mpdf->Output();
?>