<?php
$category = $con->query("SELECT * FROM tb_categorie");
$supplier = $con->query("SELECT * FROM tb_supplier");
$product = $con->query("SELECT * FROM tb_productlist");
$category = $con->query("SELECT * FROM tb_categorie");
$sub = $con->query("SELECT * FROM tb_sub_category");
$counting_unit = $con->query("SELECT * FROM tb_counting_unit");
?>

</select>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">รายการสินค้า</h3>
    <button class="btn btn-success me-2" onclick="importExcel()">นำเข้ารายชื่อสินค้าจากExcel</button>
    <button id="btn-open-add" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal3">เพิ่มสินค้า</button>
</div>

<div class="d-flex justify-content-between">
    <div class="m-3" style="min-width: 140px; width: auto;">
        <select id="option-search" class="form-control">
            <option selected hidden>เลือกดู หมวดหมู่สินค้า</option>
            <option value="all">ทั้งหมด</option>
            <?php foreach ($category as $cat) : ?>
                <option value="<?= $cat['cat_name_categorie'] ?>"><?= $cat['cat_name_categorie'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="d-flex justify-content-end py-3 me-3">
        <div class="d-flex gap-2 p-2">
            <button class="btn btn-danger py-0" id="cc-checkbox">แสดงปุ่มจัดการ</button>
        </div>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>บาร์โค้ด</th>
                    <th>รูปสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ผู้ผลิต</th>
                    <th>ราคาต้นทุนต่อหน่วย/บาท</th>
                    <th>ราคาขายสินค้าต่อหน่วน/บาท</th>
                    <th>จำนวน</th>
                    <th>ที่จัดเก็บ</th>
                    <th>สถานะ</th>
                    <th class="cc-manage d-none">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $num = 0;
                foreach ($product as $pro) :
                    $num++;
                    $catID = "SELECT * FROM tb_categorie WHERE cat_id = '$pro[c_id]' ";
                    $cat_name = mysqli_fetch_array($con->query($catID));

                    $supID = "SELECT * FROM tb_supplier WHERE sup_id = '$pro[s_id]' ";
                    $sup_name = mysqli_fetch_array($con->query($supID));
                ?>
                    <tr class="tr<?= $cat_name['cat_name_categorie'] ?>">
                        <td><?= $num ?></td>
                        <td><?= $pro['pl_product_id'] ?></td>
                        <td>
                            <button class="btn btn-secondary py-0"><a class="btn btn-secondary py-0" href="stock/Barcode.php?id=<?= $pro['id']; ?>" target="_blank"><i class="fa-solid fa-barcode"></i> Barcode</a></button>
                        </td>
                        <td>
                            <img style="width: 50px;" src="./controller/img/<?= $pro['pl_img'] ?>" alt="">
                        </td>
                        <td><?= $pro['pl_name_product'] ?></td>
                        <td class="tdcat"><?= $cat_name['cat_name_categorie'] ?></td>
                        <td><?= $sup_name['sup_name'] ?></td>
                        <td><?= number_format($pro['pl_cost']) ?></td>
                        <td><?= number_format($pro['pl_selling_price']) ?></td>
                        <td><?= $pro['pl_quantity'] ?></td>
                        <td><?= $pro['pl_storage'] ?></td>
                        <td style="text-align: center;">
                            <button class="btn btn-sm <?php
                                if ($pro['pl_quantity'] > 5) {
                                    echo 'btn-success';
                                } else if ($pro['pl_quantity'] <= 5 && $pro['pl_quantity'] >= 1) {
                                    echo 'btn-warning';
                                } else if($pro['pl_quantity'] == 0){
                                    echo 'btn-danger';
                                }else{
                                    echo 'ไม่ใด้ระบุจำนวน';
                                } ?>">
                                <?php
                                if ($pro['pl_quantity'] > 5) {
                                    echo 'ปกติ';
                                } else if ($pro['pl_quantity'] <= 5 && $pro['pl_quantity'] >= 1) {
                                    echo 'ไกล้หมด';
                                } else if($pro['pl_quantity'] == 0){
                                    echo 'หมด';
                                }else{
                                    echo 'ไม่ใด้ระบุจำนวน';
                                } ?>
                            </button>
                        </td>
                        <td class="cc-manage d-none">
                            <button class="btn btn-warning py-0" data-bs-toggle="modal" onclick="editPro(<?php echo $pro['id'] ?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0" onclick="swaldel(<?php echo $pro['id'] ?>)">ลบ</button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>


<!-- Modal-->
<div class="modal fade" id="modal3" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-head"></h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <form id="main-form" enctype="multipart/form-data">
                    <input type="hidden" id="input-id">
                    <input type="hidden" id="form-productlist">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">รหัสสินค้า</label>
                            <input id="pl_product_id" name="pl_product_id" class="form-control" type="text" placeholder="รหัสสินค้า">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ชื่อสินค้า</label>
                            <input id="pl_name_product" name="pl_name_product" class="form-control" type="text" placeholder="ชื่อสินค้า">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">หมวดหมู่</label>
                            <select id="c_id" name="c_id" class="form-control">
                                <option selected hidden>เลือกหมวดหมู่</option>
                                <?php foreach ($category as $cat) : ?>
                                    <option value="<?= $cat['cat_id'] ?>">
                                        <?= $cat['cat_name_categorie'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">หมวดหมู่ย่อย</label>
                            <select id="subcat" class="form-control">
                                <option id="opt-sub" selected hidden></option>
                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">หน่วยนับ</label>
                            <select id="pl_counting_unit" name="pl_counting_unit" class="form-control">
                                <option selected hidden>เลือกหน่วยนับ</option>
                                <?php foreach ($counting_unit as $ctu) : ?>
                                    <option value="<?= $ctu['ctu_id'] ?>">
                                        <?= $ctu['ctu_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- <div class="mb-3 col-6">
                            <label style="font-size: 10px">หน่วยนับ</label>
                            <input id="pl_counting_unit" name="pl_counting_unit" class="form-control" type="text" placeholder="หน่วยนับ">
                        </div> -->

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ราคา1</label>
                            <input id="pl_price1" name="pl_price1" class="form-control" type="text" placeholder="ราคา1">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ราคา2</label>
                            <input id="pl_price2" name="pl_pirce2" class="form-control" type="text" placeholder="ราคา2">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ราคา3</label>
                            <input id="pl_price3" name="pl_price3" class="form-control" type="text" placeholder="ราคา3">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">จำนวน</label>
                            <input id="quantity" class="form-control" type="number" min="1" value="1">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ผู้ผลิต</label>
                            <select id="s_id" name="s_id" class="form-control">
                                <option selected hidden>เลือกผู้ผลิต</option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option value="<?= $sup['sup_id'] ?>">
                                        <?= $sup['sup_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ต้นทุน</label>
                            <input id="pl_cost" name="pl_cost" class="form-control" type="text" placeholder="ต้นทุน">
                        </div>


                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">lot No.</label>
                            <input id="lot_No" name="lot_No" class="form-control" type="text" placeholder="lot No.">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ที่จัดเก็บ</label>
                            <input id="pl_storage" name="pl_storage" class="form-control" type="text" placeholder="ที่จัดเก็บ">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">วันหมดอายุ</label>
                            <input id="exp" class="form-control" type="date" min="1" placeholder="วันหมดอายุ">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">รูปภาพ</label>
                            <input id="file" name="file" onChange="showIMG(this)" class="form-control" type="file">
                            <script>
                                function showIMG(file) {
                                    $("#showIMG").attr('src', file.value);
                                    if (file.files && file.files[0]) {

                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            $('#showIMG').attr('src', e.target.result);
                                        }

                                        reader.readAsDataURL(file.files[0]);
                                    }
                                }
                            </script>
                            <img id="showIMG" style="width: 100px;" class="d-flex mx-auto mt-3">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button id="btn-productlist" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal-->
<div class="modal fade" id="ModalExcel" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายการสินค้าจาก Excel .CSV</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <form action="stock/library/excelUpload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="file" class="form-control" required>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="Submit" name="Submit" class="btn btn-primary">อัพโหลด</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <span class="text-danger text-center">ตัวอย่างไฟล์</span>
                <img src="stock/exemple.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>



<script>

    $('#c_id').change((e) => {
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType: 'html',
            data: {
                id: e.target.value,
                getsub: 1
            },
            success: (res) => {
                $('#subcat').html(res)
            }
        });
    })


    var name = ""
    // clear form
    $('#btn-open-add').click(() => {
        name = "add"
        $('#modal-head').text('เพิ่มสินค้า')
        document.getElementById("main-form").reset()
        $('#showIMG').attr('src', '')
    })

    // add productlist
    $('#btn-productlist').click(e => {
        const data = new FormData();
        data.append('form_productlist', name)
        data.append('id', $('#input-id').val())
        data.append('sub', $('#subcat').val())
        data.append('lot_No', $('#lot_No').val())
        data.append('pl_product_id', $('#pl_product_id').val())
        data.append('pl_name_product', $('#pl_name_product').val())
        data.append('c_id', $('#c_id').val())
        data.append('pl_counting_unit', $('#pl_counting_unit').val())
        data.append('pl_price1', $('#pl_price1').val())
        data.append('pl_price2', $('#pl_price2').val())
        data.append('pl_price3', $('#pl_price3').val())
        data.append('s_id', $('#s_id').val())
        data.append('pl_cost', $('#pl_cost').val())
        data.append('pl_storage', $('#pl_storage').val())
        data.append('quantity', $('#quantity').val())
        data.append('exp', $('#exp').val())
        data.append('file', $('#file')[0].files[0])

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                $('#modal3').modal('hide')
                if(res == 1) {
                    swalsuccess()
                    setTimeout(() => location.reload(), 1200)
                }else{ swalerror() }
            }
        });
    })


    // update
    function editPro(id) {
        name = "update"
        $('#modal-head').text('แก้ไข')
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                editPro: 1
            },
            success: (res) => {
                $('#pl_product_id').val(res.pl_product_id)
                $('#pl_name_product').val(res.pl_name_product)
                $('#c_id').val(res.c_id)
                $('#pl_counting_unit').val(res.pl_counting_unit)
                $('#pl_price1').val(res.pl_price1)
                $('#pl_price2').val(res.pl_price2)
                $('#pl_price3').val(res.pl_price3)
                $('#s_id').val(res.s_id)
                $('#pl_cost').val(res.pl_cost)
                $('#pl_storage').val(res.pl_storage)
                $('#quantity').val(res.pl_quantity)
                $('#exp').val(res.pl_exp)
                $('#lot_No').val(res.pl_lot_no)
                $('#input-id').val(res.id)
                getsub(res.sub_id)
                $('#showIMG').attr('src', `controller/img/${res.pl_img}`)
                $('#modal3').modal('show')
            }
        });
    }

    const getsub = (id) => {
        $('#subcat').html('')
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                getsubc: 1
            },
            success: (res) => {
                $('#subcat').append('<option id="opt-sub" selected hidden></option>')
                $('#opt-sub').val(res.sub_id)
                $('#opt-sub').text(res.sub_name)
            }
        }) 
    }

    function importExcel() {
        $('#ModalExcel').modal('show')
    }


    // delete productlist
    const delPro = (id) => {
        const data = new FormData()
        data.append('form_productlist', "delete")
        data.append('id', id)
        data.append('delPro', 1)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                swalsuccess()
                setTimeout(() => location.reload(), 1200)
            }
        })
    }

    // Current data
    const currentData = () => {
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType: 'json',
            data: {
                getdata: 1
            },
            success: (res) => {
                // 
            }
        })
    }


    // sweet alert delete
    const swaldel = (id) => {
        Swal.fire({
            text: "ต้องการลบหรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'blue',
            cancelButtonColor: 'red',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                delPro(id)
            }
        })
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
    // sweet alert error
    const swalerror = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }

    // hidden manage button
    $('#cc-checkbox').click((e) => $('.cc-manage').toggleClass("d-none"))

    // search option table
    $('#option-search').change((e) => {
        if (e.target.value == "all") {
            getall()
        } else {
            $('tr').removeClass("d-none")
            const tdcat = document.querySelectorAll(".tdcat")
            tdcat.forEach(td => {
                if (td.textContent != e.target.value) {
                    $(`.tr${td.textContent}`).addClass("d-none")
                }
            })
        }
    })

    const getall = () => {
        const alltr = document.querySelectorAll("tbody tr")
        alltr.forEach(all => all.classList.remove("d-none"))
    }
</script>