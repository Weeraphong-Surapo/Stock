<?php $productlist = $con->query("SELECT * FROM tb_productlist"); ?>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ตั่งค่าส่วนลด</h3>
</div>

<form id="cc-search-1" class="d-flex gap-2 p-3">
    <input id="search-table" class="form-control" style="width: 300px;" type="text" placeholder="ค้นหา">
</form>

<div class="portlet-body">
    <!-- <p>Make your tables always responsive, use <code>.table-responsive</code> for horizontally scrolling tables.</p> -->
    <!-- <p>Use <code>.table-responsive{-sm|-md|-lg|-xl|-xxl}</code> as needed to create responsive tables up to a particular breakpoint. From that breakpoint and up, the table will behave normally and not scroll horizontally.</p> -->
    <!-- BEGIN Table -->
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคาขาย/บาท</th>
                    <th style="width: 150px;">ส่วนลด/บาท</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $num = 0;
                    foreach($productlist as $pro):
                        $num++;
                        $catID = "SELECT * FROM tb_categorie WHERE cat_id = '$pro[c_id]' ";
                        $cat_name = mysqli_fetch_array($con->query($catID))
                ?>
                <tr >
                    <td><?=$num?></td>
                    <td><?=$pro['pl_product_id']?></td>
                    <td><?=$pro['pl_name_product']?></td>
                    <td><?=$cat_name['cat_name_categorie']?></td>
                    <td><?=number_format($pro['pl_selling_price'])?></td>
                    <td id="td-dis<?=$pro['id']?>" class="td-dis"><?=number_format($pro['pl_discount'])?></td>
                    <td id="td-disin<?=$pro['id']?>" class="td-disin">
                        <input id="input<?=$pro['id']?>" type="number" min="1" value="<?=$pro['pl_discount']?>" class="form-control input1">
                    </td>
                    <td id="td-edit<?=$pro['id']?>" class="td-edit">
                        <button class="btn btn-warning btn-edit" onclick="editdata(<?=$pro['id']?>)">แก้ไข</button>
                    </td>
                    <td id="<?=$pro['id']?>" class="d-flex gap-1 cc-save">
                        <button class="btn btn-success btn-save" onclick="savedata(<?=$pro['id']?>)">บันทึก</button>
                        <button class="btn btn-danger btn-cancel">ยกเลิก</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>



<script>
    $('#search-table').keyup(() => {
        search_table($('#search-table').val())
    })

    const search_table = (value) => {
        $('#cc-table tbody tr').each((index, element) => {
            var found = false
            $(element).find('td').each((index, td) => {
                if($(td).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) found = true
            })
            if(found) $(element).show()   
            else $(element).hide()
        })
    }

    $('.cc-save').addClass("d-none")
    $('.td-disin').addClass("d-none")
    $('.btn-cancel').click(() => {
        $('.cc-save').addClass("d-none")
        $('.td-disin').addClass("d-none")
        $('.td-edit').removeClass("d-none")
        $('.td-dis').removeClass("d-none")
    })
    const editdata = (id) => {
        const discount = document.querySelectorAll(".td-disin")
        discount.forEach(dis => {
            if(dis.id == `td-disin${id}`){
                dis.classList.remove("d-none")
            }else dis.classList.add("d-none")
        })
        
        const discount2 = document.querySelectorAll(".td-dis")
        discount2.forEach(dis2 => {
            if(dis2.id == `td-dis${id}`){
                dis2.classList.add("d-none")
            }else dis2.classList.remove("d-none")
        })

        const button = document.querySelectorAll(".td-edit")
        button.forEach(btn => {
            if(btn.id == `td-edit${id}`){
                btn.classList.add("d-none")
            }else btn.classList.remove("d-none")
        })
        const save = document.querySelectorAll(".cc-save")
        save.forEach(s => {
            if(s.id == id){
                s.classList.remove("d-none")
            }else s.classList.add("d-none")
        })
    }

    // save
    const savedata = (id) => {
        const input1 = document.querySelectorAll(".input1")
        input1.forEach(in1 => {
            if(in1.id == `input${id}`){
                update_dis(id, in1.value)
            }
        })
    }

    // update
    function update_dis(id, value) {
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                dis: value,
                update_discount: 1
            },
            success: (res) => {
                swalsuccess()
                $('#td-disin').val(res.pl_discount)
                $(`#td-dis${id}`).text(res.pl_discount)
            }
        });
    }

    // sweet alert success
    const swalsuccess = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'success',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }


</script>


