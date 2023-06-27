<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

require('php-excel-reader/excel_reader2.php');
require('SpreadsheetReader.php');
require('../../config/connect.php');


if(isset($_POST['Submit'])){


  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  if(in_array($_FILES["file"]["type"],$mimes)){


    $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);


    $Reader = new SpreadsheetReader($uploadFilePath);


    $totalSheet = count($Reader->sheets());



    /* For Loop for all sheets */
    for($i=0;$i<$totalSheet;$i++){


      $Reader->ChangeSheet($i);


      foreach ($Reader as $Row)
      {
        $pl_product_id = isset($Row[0]) ? $Row[0] : '';
        $pl_name_product = isset($Row[1]) ? $Row[1] : '';
        $pl_cost = isset($Row[2]) ? $Row[2] : '';
        $pl_selling_price = isset($Row[3]) ? $Row[3] : '';
        $pl_quantity = isset($Row[4]) ? $Row[4] : '';


        $query = "INSERT INTO  tb_productlist(pl_product_id,pl_name_product,pl_cost,pl_selling_price,pl_quantity) 
        VALUES('".$pl_product_id."','".$pl_name_product."','".$pl_cost."','".$pl_selling_price."','".$pl_quantity."')";

        $con->query($query);
       }
    }
    echo "<script>
    Swal.fire(
      'นำสินค้าเข้าระบบสำเร็จ!',
      '',
      'success'
    )
    setTimeout(()=>{location.href='../../index?p=productlist'},1200);
    </script>";

  }else { 
    echo "<script>
    Swal.fire(
      'ประเภทไฟล์ไม่ถูกต้อง!',
      'กรุณาตรวจสอบสอบไฟล์!',
      'error'
    )
    setTimeout(()=>{location.href='../../index?p=productlist'},1200);
    </script>";
  }


}


?>