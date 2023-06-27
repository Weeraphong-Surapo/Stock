<?php
    require_once('../config/connect.php');


    // add product
    if(isset($_POST['form_productlist']) && $_POST['form_productlist'] == 'add'){
        $file_img = rand(10000000, 99999999).$_FILES['file']['name'];

        $nameFile =  array('png' ,'jpg', 'pdf', 'webp', 'jpeg');
        $nameFileImg = pathinfo($file_img, PATHINFO_EXTENSION);
        if(!in_array($nameFileImg, $nameFile)) {
            echo "ภาพไม่ถูก";
        }else{
            $sql = "INSERT INTO tb_productlist(
                pl_product_id, 
                pl_img, 
                pl_name_product, 
                c_id, 
                pl_counting_unit, 
                pl_price1, 
                pl_price2, 
                pl_price3, 
                s_id, 
                pl_cost, 
                pl_storage,
                pl_quantity,
                pl_exp,
                pl_lot_no,
                sub_id
            ) 
            VALUES (
                '".$_POST['pl_product_id']."',
                '$file_img',
                '".$_POST['pl_name_product']."',
                '".$_POST['c_id']."',
                '".$_POST['pl_counting_unit']."',
                '".$_POST['pl_price1']."',
                '".$_POST['pl_price2']."',
                '".$_POST['pl_price3']."',
                '".$_POST['s_id']."',
                '".$_POST['pl_cost']."',
                '".$_POST['pl_storage']."',
                '".$_POST['quantity']."',
                '".$_POST['exp']."',
                '".$_POST['lot_No']."',
                '".$_POST['sub']."'
            )";
            if($con->query($sql)){
                $location = 'img/';
                move_uploaded_file($_FILES['file']["tmp_name"],$location.$file_img);
                echo 1;
            }else{ echo $sql; }
        }
    }


    // get data productlist
    if(isset($_POST['editPro'])){
        $query = $con->query("SELECT * FROM tb_productlist WHERE id = '$_POST[id]'");
        $res = $query->fetch_array();
        echo json_encode($res);
    }

    // update product
    if(isset($_POST['form_productlist']) && $_POST['form_productlist'] == "update"){
        if(isset($_FILES['file'])){
            $file_img = rand(10000000, 99999999).$_FILES['file']['name'];

            $nameFile =  array('png' ,'jpg', 'pdf', 'webp', 'jpeg');
            $nameFileImg = pathinfo($file_img, PATHINFO_EXTENSION);
            if(!in_array($nameFileImg, $nameFile)) {
                echo "ภาพไม่ถูก";
                exit;
            }else{
                $up_file = "UPDATE tb_productlist SET pl_img = '$file_img' WHERE id = '$_POST[id]' ";
                if($con->query($up_file)){
                    $location = 'img/';
                    move_uploaded_file($_FILES['file']["tmp_name"],$location.$file_img);
                }
            }  
        }
        $update = "UPDATE tb_productlist SET
            pl_product_id = '$_POST[pl_product_id]',
            pl_name_product = '$_POST[pl_name_product]',
            c_id = '$_POST[c_id]',
            pl_counting_unit = '$_POST[pl_counting_unit]',
            pl_price1 = '$_POST[pl_price1]',
            pl_price2 = '$_POST[pl_price2]',
            pl_price3 = '$_POST[pl_price3]',
            s_id = '$_POST[s_id]',
            pl_cost = '$_POST[pl_cost]',
            pl_storage = '$_POST[pl_storage]',
            pl_quantity = '$_POST[quantity]',
            pl_exp = '$_POST[exp]',
            pl_lot_no = '$_POST[lot_No]'
            WHERE id = '$_POST[id]'
        ";
        echo $con->query($update) ? 1 : 0;
    }


    // delete product
    if(isset($_POST['form_productlist']) && $_POST['form_productlist'] == "delete"){
        if($con->query("DELETE FROM tb_productlist WHERE id = '$_POST[id]' ")){
            echo "success";
        }
        else{ echo "no del"; }
    }

    // search productlsit
    if(isset($_POST['search']) && $_POST['id']){
        $search = $con->query("SELECT * FROM tb_productlist WHERE pl_product_id = '$_POST[id]'");
        if(mysqli_num_rows($search) == 0){
            echo '<h5 class="text-danger">ไม่พบข้อมูล</h5>';
        }
        else{
            $res = $search->fetch_array();
            $totalPrice = $res['pl_cost'] * $res['pl_quantity'];
            $outp = '
                <tr>
                    <td>1</td>
                    <td>'.$res["pl_name_product"].'</td>
                    <td>'.$res["pl_product_id"].'</td>
                    <td>'.$res["pl_storage"].'</td>
                    <input type="hidden" id="cc-id" value="'.$res["id"].'">
                    <td class="td-input"><input type="number" step="0.00" id="cc-cost" value="'.$res["pl_cost"].'" class="form-control cc-res-input"></td>
                    <td class="td-input"><input type="number" step="0.00" id="cc-qty" value="'.$res["pl_quantity"].'" class="form-control cc-res-input"></td>
                    <td class="td-input"><input type="number" step="0.00" id="cc-sum" value="'.$totalPrice.'" class="form-control cc-res-input" disabled></td>
                    <td class="cc-manage d-none">
                        <button class="btn btn-danger" onclick="swaldel('.$res['id'].')">ลบ</button>
                    </td>
                </tr> 
                <script>
                    $("#cc-cost").keyup((e) => {
                        $("#cc-sum").val($("#cc-qty").val() * e.target.value)
                    })
                    $("#cc-qty").keyup((e) => {
                        $("#cc-sum").val($("#cc-cost").val() * e.target.value)
                    })
                </script>
            ';
            echo $outp;
        }
    }

    // save import product
    if(isset($_POST['saveimport']) && $_POST['id']){
        $update = "UPDATE tb_productlist SET
            pl_cost = '$_POST[cost]',
            pl_quantity = '$_POST[qty]'
            WHERE id = '$_POST[id]'
        ";
        if($con->query($update)){
            $search = $con->query("SELECT * FROM tb_productlist WHERE id = '$_POST[id]'");
            $res = $search->fetch_array();
            $totalPrice = $res['pl_cost'] * $res['pl_quantity'];
            $outp = '
                <tr>
                    <td>1</td>
                    <td>'.$res["pl_name_product"].'</td>
                    <td>'.$res["pl_product_id"].'</td>
                    <td>'.$res["pl_storage"].'</td>
                   <input type="hidden" id="cc-id" value="'.$res["id"].'">
                    <td class="td-input"><input type="number" step="0.00" id="cc-cost" value="'.$res["pl_cost"].'" class="form-control cc-res-input"></td>
                    <td class="td-input"><input type="number" step="0.00" id="cc-qty" value="'.$res["pl_quantity"].'" class="form-control cc-res-input"></td>
                    <td class="td-input"><input type="number" step="0.00" id="cc-sum" value="'.$totalPrice.'" class="form-control cc-res-input" disabled></td>
                    <td class="cc-manage d-none">
                        <button class="btn btn-danger" onclick="swaldel('.$res['id'].')">ลบ</button>
                    </td>
                </tr> 
                <script>
                    $("#cc-cost").keyup((e) => {
                        $("#cc-sum").val($("#cc-qty").val() * e.target.value)
                    })
                    $("#cc-qty").keyup((e) => {
                        $("#cc-sum").val($("#cc-cost").val() * e.target.value)
                    })
                </script>
            ';
            echo $outp;
        }else echo $update;
    }

    // update discount
    if(isset($_POST['update_discount']) && $_POST['update_discount'] == 1){
        $update = "UPDATE tb_productlist SET pl_discount = '$_POST[dis]' WHERE id = '$_POST[id]' ";
        if($con->query($update)){
            $select = $con->query("SELECT * FROM tb_productlist WHERE id = '$_POST[id]'");
            $res = $select->fetch_array();
            echo json_encode($res);
        }else echo $update;
    }


    // add customer
    if(isset($_POST['form_mycustomer']) && $_POST['form_mycustomer'] == 'addcus'){
        $member_card = rand(100000, 999999);
        $check = $con->query("SELECT * FROM tb_customer WHERE cus_member_card = '$member_card'");
        while($check->num_rows > 0){
            $member_card = rand(100000, 999999);
            $check = $con->query("SELECT * FROM tb_customer WHERE cus_member_card = '$member_card'");
        }
        $insert = "INSERT INTO tb_customer (
            cus_name,
            cus_lastname,
            cus_address,
            cus_province,
            cus_amphoe,
            cus_tambon,
            cus_phone,
            cus_date,
            cus_email,
            cus_gender,
            cus_group,
            cus_level,
            cus_note,
            cus_member_card
        ) VALUES (
            '$_POST[cus_name]',
            '$_POST[cus_lastname]',
            '$_POST[cus_address]',
            '$_POST[cus_province]',
            '$_POST[cus_amphoe]',
            '$_POST[cus_tambon]',
            '$_POST[cus_phone]',
            '$_POST[cus_date]',
            '$_POST[cus_email]',
            '$_POST[cus_gender]',
            '$_POST[cus_group]',
            '$_POST[cus_level]',
            '$_POST[cus_note]',
            '$member_card'
        )";
        if($con->query($insert)){
            echo "ok";
        }else{
            echo $insert;
        }
    }


    // get data customer
    if(isset($_POST['updatecus']) && $_POST['updatecus'] == 'getid'){
        $query = $con->query("SELECT * FROM tb_customer WHERE cus_id = '$_POST[id]'");
        $res = $query->fetch_array();
        echo json_encode($res);
    }

    // update customer 
    if(isset($_POST['form_mycustomer']) && $_POST['form_mycustomer'] == 'updatecus'){
        $update = "UPDATE tb_customer SET
            cus_name = '$_POST[cus_name]',
            cus_lastname = '$_POST[cus_lastname]',
            cus_address = '$_POST[cus_address]',
            cus_province = '$_POST[cus_province]',
            cus_amphoe = '$_POST[cus_amphoe]',
            cus_tambon = '$_POST[cus_tambon]',
            cus_phone = '$_POST[cus_phone]',
            cus_date = '$_POST[cus_date]',
            cus_email = '$_POST[cus_email]',
            cus_gender = '$_POST[cus_gender]',
            cus_group = '$_POST[cus_group]',
            cus_level = '$_POST[cus_level]',
            cus_note = '$_POST[cus_note]'
            WHERE cus_id = '$_POST[id]'
        ";
        if($con->query($update)){
            echo "success";
        }else echo $update;
    }

    // delete customer
    if(isset($_POST['form_mycustomer']) && $_POST['form_mycustomer'] == "deletecus"){
        if($con->query("DELETE FROM tb_customer WHERE cus_id = '$_POST[id]' ")){
            echo "success";
        }
        else{ echo "no del"; }
    }

    // select province, amphoe, tambon
    if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM amphures WHERE province_id='$id'";
        $query = mysqli_query($con, $sql);
        echo '<option value="" selected disabled>เลือกอำเภอ</option>';
        foreach ($query as $value) {
            echo '<option value="'.$value['id'].'">'.$value['name_th'].'</option>'; 
        }
    }


    if (isset($_POST['function']) && $_POST['function'] == 'amphures') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM districts WHERE amphure_id='$id'";
        $query = mysqli_query($con, $sql);
        echo '<option value="" selected disabled>เลือกตำบล</option>';
        foreach ($query as $value2) {
            echo '<option value="'.$value2['id'].'">'.$value2['name_th'].'</option>';
        }
    }
    // end select province, amphoe, tambon

    // get amphoe
    if(isset($_POST['getamphoe']) && $_POST['getamphoe'] == 1){
        $select = $con->query("SELECT * FROM amphures WHERE id = '$_POST[id]'");
        $res = $select->fetch_array();
        echo json_encode($res);
    }

    // get tambon
    if(isset($_POST['gettambon']) && $_POST['gettambon'] == 1){
        $select = $con->query("SELECT * FROM districts WHERE id = '$_POST[id]'");
        $res = $select->fetch_array();
        echo json_encode($res);
    }

    // add customer group
    if(isset($_POST['form_group']) && $_POST['form_group'] == 'addgroup'){
        $insert = "INSERT INTO customer_group (cg_name, cg_note) VALUES ('$_POST[cg_name]', '$_POST[cg_note]')";
        if($con->query($insert)){
            echo "success";
        }else echo $insert;
    }

    // get data customer group
    if(isset($_POST['updategroup']) && $_POST['updategroup'] == 1){
        $query = $con->query("SELECT * FROM customer_group WHERE cg_id = '$_POST[id]'");
        $res = $query->fetch_array();
        echo json_encode($res);
    }

    // update customer group
    if(isset($_POST['form_group']) && $_POST['form_group'] == "updategroup"){
        $update = "UPDATE customer_group SET
            cg_name = '$_POST[cg_name]',
            cg_note = '$_POST[cg_note]'
            WHERE cg_id = '$_POST[id]'
        ";
        if($con->query($update)){
            echo "successS";
        }else echo $update;
    }

    // add supplier
    if(isset($_POST['form_sup']) && $_POST['form_sup'] == 'addsup'){
        $file_img = rand(10000000, 99999999).$_FILES['file']['name'];

        $nameFile =  array('png' ,'jpg', 'pdf', 'webp', 'jpeg');
        $nameFileImg = pathinfo($file_img, PATHINFO_EXTENSION);
        if(!in_array($nameFileImg, $nameFile)) {
            echo "ภาพไม่ถูก";
        }else{
            $insert = "INSERT INTO tb_supplier (
                sup_member_id,
                sup_name,
                sup_vat_number,
                sup_img,
                sup_address,
                sup_phone,
                sup_birthday
            ) VALUES (
                '$_POST[id]',
                '$_POST[name]',
                '$_POST[vat]',
                '$file_img',
                '$_POST[address]',
                '$_POST[phone]',
                '$_POST[birthday]'
            )";
            if($con->query($insert)){
                $location = 'img/';
                move_uploaded_file($_FILES['file']["tmp_name"],$location.$file_img);
                echo "success";
            }else echo $insert;
        }
    }


    // get data supplier
    if(isset($_POST['getsup']) && $_POST['getsup'] == 1){
        $query = $con->query("SELECT * FROM tb_supplier WHERE sup_id = '$_POST[id]'");
        $res = $query->fetch_array();
        echo json_encode($res);
    }

    // update supplier
    if(isset($_POST['form_supplier']) && $_POST['form_supplier'] == 'updatesup'){
        if(isset($_FILES['file'])){
            $file_img = rand(10000000, 99999999).$_FILES['file']['name'];

            $nameFile =  array('png' ,'jpg', 'pdf', 'webp', 'jpeg');
            $nameFileImg = pathinfo($file_img, PATHINFO_EXTENSION);
            if(!in_array($nameFileImg, $nameFile)) {
                echo "ภาพไม่ถูก";
                exit;
            }else{
                $up_file = "UPDATE tb_supplier SET sup_img = '$file_img' WHERE sup_id = '$_POST[id]' ";
                if($con->query($up_file)){
                    $location = 'img/';
                    move_uploaded_file($_FILES['file']["tmp_name"],$location.$file_img);
                }
            }  
        }
        $update = "UPDATE tb_supplier SET
            sup_member_id = '$_POST[member_id]',
            sup_name = '$_POST[name]',
            sup_vat_number = '$_POST[vat]',
            sup_address = '$_POST[address]',
            sup_phone = '$_POST[phone]',
            sup_birthday = '$_POST[birthday]'
            WHERE sup_id = '$_POST[id]'
        ";
        if($con->query($update)){
            echo 1;
        }else echo $update;
    }



    // level customer
    if(isset($_POST['addLavel'])){
        $res = 0;
        if(!empty($_POST['id'])){
            $res = 2;
            $sql = "UPDATE `customer_level` SET `lv_level`='$_POST[lavel]',`lv_note`='$_POST[des]' WHERE `lv_id` = '$_POST[id]'";
        }else{
            $res = 1;
            $sql = "INSERT INTO `customer_level`(`lv_level`, `lv_note`) VALUES ('$_POST[lavel]','$_POST[des]')";
        }
        if(!$con->query($sql)){ $res = 0;}
        echo $res;
    }

    if(isset($_POST['editLavel'])){
        $sql = "SELECT * FROM `customer_level` WHERE `lv_id` = '$_POST[id]'";
        $query = $con->query($sql);
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    if(isset($_POST['deleteLavel'])){
        $con->query("DELETE FROM `customer_level` WHERE `lv_id` = '$_POST[id]'");
    }

    // delete supplier
    if(isset($_POST['form_supplier']) && $_POST['form_supplier'] == 'delsup'){
        $delete = "DELETE FROM tb_supplier WHERE sup_id = '$_POST[id]'";
        echo $con->query($delete) ? 1 : 0;
    }

    // add gender
    if(isset($_POST['form_gender']) && $_POST['form_gender'] == 'addgender'){
        $insert = "INSERT INTO customer_gender (gen_gender, gen_note) VALUES ('$_POST[gender]', '$_POST[note]')";
        if($con->query($insert)){
            echo 1;
        }else echo $insert;
    }

    // update gender
    if(isset($_POST['updategender']) && $_POST['updategender'] == 1){
        $sql = $con->query("SELECT * FROM customer_gender WHERE gen_id = '$_POST[id]'");
        $res = $sql->fetch_array();
        echo json_encode($res);
    }

    // update customer gender
    if(isset($_POST['form_gender']) && $_POST['form_gender'] == "updategender"){
        $update = "UPDATE customer_gender SET
            gen_gender = '$_POST[gender]',
            gen_note = '$_POST[note]'
            WHERE gen_id = '$_POST[id]'
        ";
        if($con->query($update)){
            echo 1;
        }else echo $update;
    }

    // delete gender
    if(isset($_POST['form_gender']) && $_POST['form_gender'] == 'delgen'){
        $delete = "DELETE FROM customer_gender WHERE gen_id = '$_POST[id]'";
        echo $con->query($delete) ? 1 : 0;
    }

    // delete group
    if(isset($_POST['form_group']) && $_POST['form_group'] == 'delgroup'){
        $delete = "DELETE FROM customer_group WHERE cg_id = '$_POST[id]'";
        echo $con->query($delete) ? 1 : 0;
    } 

    // search borrow
    if(isset($_POST['searchborrow']) && $_POST['id']){
        $search = $con->query("SELECT * FROM tb_productlist WHERE pl_product_id = '$_POST[id]'");
        if(mysqli_num_rows($search) == 0){
            echo '<h5 class="text-danger">ไม่พบข้อมูล</h5>';
        }
        else{
            $res = $search->fetch_array();
            $outp = '
            <tr>
                <td>1</td>
                <td id="product">'.$res["pl_name_product"].'</td>
                <td id="product-id">'.$res["pl_product_id"].'</td>
                <td id="storage">'.$res["pl_storage"].'</td>
                <td id="oldqty">'.$res["pl_quantity"].'</td>
                <td style="width: 180px;">
                <input id="qtyborrow" min="1" type="number" class="form-control">
                <span class="text-danger" style="font-size: 12px;" id="nosave"></span>
                </td>
                <td style="width: 180px;"><input id="dateborrow" type="date" class="form-control"></td>
                </tr> 
            ';
            echo $outp;
        }
    }

    // save borrow
    if(isset($_POST['saveborrow']) && $_POST['id']){

        $newqty = $_POST['oldqty'] - $_POST['qtyborrow'];
        $update = "UPDATE tb_productlist SET pl_quantity = '$newqty' WHERE pl_product_id = '$_POST[id]' ";
        $insert = "INSERT INTO tb_borrow (
                pl_name_product,
                pl_product_id,
                pl_storage,
                bor_quantity,
                bor_date
            ) VALUES (
                '$_POST[product]',
                '$_POST[id]',
                '$_POST[storage]',
                '$_POST[qtyborrow]',
                '$_POST[dateborrow]'
            )
        ";
        
        echo $con->query($update) && $con->query($insert) ? 1 : 0;
    }

    // get data borrow
    if(isset($_POST['getborrow']) && $_POST['id']){
        $select = $con->query("SELECT * FROM tb_borrow WHERE bor_id = '$_POST[id]'");
        $res = $select->fetch_array();
        echo json_encode($res);
    }

    // return borrow 
    if(isset($_POST['form_borrow']) && $_POST['form_borrow'] == "returnborrow"){
        $select = $con->query("SELECT pl_quantity FROM tb_productlist WHERE pl_product_id = '$_POST[id]' ");
        $qty = $select->fetch_array();
        $newqty = $qty['pl_quantity'] + $_POST['qtyreturn'];
        $update = "UPDATE tb_productlist SET pl_quantity = '$newqty' WHERE pl_product_id = '$_POST[id]'";
        $currentqty = $_POST['qty'] - $_POST['qtyreturn'];
        if($currentqty < 1) $borrow = "DELETE FROM tb_borrow WHERE bor_id = '$_POST[bor_id]'";
        else $borrow = "UPDATE tb_borrow SET 
            bor_qtyreturn = '$_POST[qtyreturn]',
            bor_datereturn = '$_POST[datereturn]',
            bor_quantity = '$currentqty'
            WHERE bor_id = '$_POST[bor_id]'
        ";
        
        echo $con->query($update) && $con->query($borrow) ? 1 : 0;
    }

    // delete borrow
    if(isset($_POST['form_borrow']) && $_POST['form_borrow'] == 'delborrow'){
        $select = $con->query("SELECT *
            FROM tb_borrow
            LEFT JOIN tb_productlist ON tb_borrow.pl_product_id = tb_productlist.pl_product_id
            WHERE tb_borrow.bor_id = '$_POST[id]'");
        $data = $select->fetch_array();
        $newqty = $data['bor_quantity'] + $data['pl_quantity'];
        $update = "UPDATE tb_productlist SET pl_quantity = '$newqty' WHERE pl_product_id = '$data[pl_product_id]'";
        $delete = "DELETE FROM tb_borrow WHERE bor_id = '$_POST[id]'";

        echo $con->query($update) && $con->query($delete) ? 1 : 0;
    } 


    if(isset($_POST['findOrder'])){
        $sql = "SELECT * FROM tb_order_product WHERE sp_id = '$_POST[id]'";
        $query = $con->query($sql);
        $sql_sale = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$_POST[id]'");
        $row_sale = $sql_sale->fetch_array();
        $outp = '';
        $detail = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$_POST[id]'");
        $rows = $detail->fetch_array();
        $sql = "SELECT * FROM tb_order_product WHERE sp_id = '$_POST[id]'";
        $query = $con->query($sql);
        $i = 1;
            $outp = '<div class="table-responsive"><table class="table table-bordered">
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
        $outp .= '</table></div>';
        echo $outp;
    }

    if(isset($_POST['billFull'])){
        $sql = "SELECT * FROM tb_order_product WHERE sp_id = '$_POST[id]'";
        $query = $con->query($sql);
        $sql_sale = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$_POST[id]'");
        $row_sale = $sql_sale->fetch_array();
        $outp = '';
        $detail = $con->query("SELECT * FROM tb_sale_product WHERE sp_id = '$_POST[id]'");
        $rows = $detail->fetch_array();
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
            <h3 style="margin: 15px; margin-bottom: 5px;">PORNCHAI SERVICE</h3>
            <div style="display: flex; margin-left: 15px;">
                <h6>รหัสรายการ: '.$row_sale['order_code'].'</h6>
                <h6>, ชื่อลูกค้า:  '. $name.$lastname.'</h6>
                <h6>, ที่อยู่: '.$address.'</h6>
            </div>
            <div class="table-responsive"><table class="table table-bordered">
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
                $total += $row_product['pl_selling_price'] * $row['qty'];
                $total_qty += $row['qty'];
            $outp .= '
                <tr>
                    <td>'.$i++.'</td>
                    <td>'.$row_product['pl_name_product'].'</td>
                    <td>'.$row_product['pl_product_id'].'</td>
                    <td style="text-align:right;">'.number_format($row_product['pl_selling_price'],'2').'</td>
                    <td style="text-align:right;">'.number_format($row['pl_discount'],'2').'</td>
                    <td style="text-align:right;">'.$row['qty'].'</td>
                    <td style="text-align:right;">'.number_format($rows['sp_sell'],'2').'</td>
                </tr>';
        }
        $outp .= '<tr style="text-align:right;">
            <td colspan="5">รวม</td>
            <td>'.number_format($total_qty).'</td>
            <td>'.number_format($total,'2').'</td>
        </tr>';
        $outp .= '<tr>
            <td style="text-align:right;" colspan="6">รับเงิน</td>
            <td style="text-align:right;">'.number_format($rows['get_money'],'2').'</td>
        </tr>
        <tr>
            <td style="text-align:right;" colspan="6">ทอนเงิน</td>
            <td style="text-align:right;">'.number_format($rows['change_money'],'2').'</td>
        </tr>';
        $outp .= '</table></div>';
        echo $outp;
    }

    if(isset($_POST['deleteSub'])){
        $query = $con->query("DELETE FROM tb_sub_category WHERE sub_id = '$_POST[id]'");
    }

    if(isset($_POST['addSub'])){
        $res = 0;
        if(!empty($_POST['id'])){
            $res = 0;
            $query = $con->query("UPDATE tb_sub_category SET sub_name = '$_POST[subcategory]' ,category_id = '$_POST[category]' WHERE sub_id = '$_POST[id]'");
        }else{
            $res = 1;
            $query = $con->query("INSERT INTO tb_sub_category(sub_name,category_id) VALUES('$_POST[subcategory]','$_POST[category]')");
        }
        echo $res;
    }

    if(isset($_POST['editSub'])){
        $query = $con->query("SELECT * FROM tb_sub_category WHERE sub_id = '$_POST[id]'");
        $row = $query->fetch_array();
        echo json_encode($row);
    }

    // get data sub category
    if(isset($_POST['getsub'])){
        $select = $con->query("SELECT * FROM tb_sub_category WHERE category_id = '$_POST[id]'");
        echo '<option value="" selected hidden>เลือกหมวดหมู่ย่อย</option>';
        foreach ($select as $sub) {
            echo '<option value="'.$sub['sub_id'].'">'.$sub['sub_name'].'</option>';
        }
    }

    // get sub
    if(isset($_POST['getsubc'])){
        $select = $con->query("SELECT * FROM tb_sub_category WHERE sub_id = '$_POST[id]'");
        $res = $select->fetch_array();
        echo json_encode($res);
    }
