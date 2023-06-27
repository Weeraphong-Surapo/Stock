<?php $supplier = $con->query("SELECT * FROM tb_supplier"); ?>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ผู้ผลิต/เจ้าของสินค้า</h3>
</div>

<div class="ms-3 mt-3 d-flex">
    <input style="width: 200px;" type="text" placeholder="ค้นหา" id="search-table" class="form-control cc-input2" >
    <button class="btn btn-secondary ms-2" id="btn-reset">รีเฟรช</button>
</div>

<div class="d-flex justify-content-end me-3">
    <div class="d-flex gap-2">
        <button class="btn btn-danger py-0" id="cc-checkbox">แสดงปุ่มลบ</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสมาชิก</th>
                    <th>ชื่อ</th>
                    <th>เลขบัตร/เลขเสียภาษี</th>
                    <th>รูป</th>
                    <th>ที่อยู่</th>
                    <th>โทร</th>
                    <th>วันเกิด</th>
                    <th>จัดการ</th>
                </tr>
            </thead>

            <tbody>
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" id="member-id" class="form-control">
                        </td>
                        <td>
                            <input type="text" id="name" class="form-control">
                        </td>
                        <td>
                            <input type="text" id="vat-num" class="form-control">
                        </td>
                        <td>
                            <input type="file" id="file" class="form-control">
                        </td>
                        <td>
                            <textarea rows="1" type="text" id="address" class="form-control"></textarea>
                        </td>
                        <td>
                            <input type="text" id="phone" class="form-control">
                        </td>
                        <td>
                            <input type="text" id="birthday" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-success" id="btn-sup">บันทึก</button>
                        </td>
                    </tr>

                    <?php
                        $num = 0;
                        foreach($supplier as $sup):
                            $num++;
                    ?>
                    <tr>
                        <td><?=$num?></td>
                        <td><?=$sup['sup_member_id']?></td>
                        <td><?=$sup['sup_name']?></td>
                        <td><?=$sup['sup_vat_number']?></td>
                        <td>
                            <img style="width: 50px;" src="./controller/img/<?= $sup['sup_img'] ?>" alt="">
                        </td>
                        <td><?=$sup['sup_address']?></td>
                        <td><?=$sup['sup_phone']?></td>
                        <td><?=$sup['sup_birthday']?></td>
                        <td class="">
                            <button class="btn btn-warning py-0" data-bs-toggle="modal" onclick="getdata(<?=$sup['sup_id']?>)">แก้ไข</button>
                            <button class="btn btn-danger py-0 cc-manage d-none" onclick="swaldel(<?=$sup['sup_id']?>)">ลบ</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>

            </tbody>
        </table>
        <!-- <button class="btn btn-secondary m-3 ms-0">ดาวโหลด Excel</button> -->
    </div>
    <!-- END Table -->
</div>



<!-- Modal-->
<div class="modal fade" id="modal3" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสินค้า</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <form id="main-form" enctype="multipart/form-data">
                    <input type="hidden" id="input-id2">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">รหัสสมาชิก</label>
                            <input id="member-id2" class="form-control" type="text">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ชื่อ</label>
                            <input id="name2" class="form-control" type="text">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">เลขบัตร/เลขเสียภาสี</label>
                            <input id="vat-num2" class="form-control" type="text">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">เบอร์โทร</label>
                            <input id="phone2" class="form-control" type="text">
                        </div>

                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">รูป</label>
                            <input id="file2" name="file" onChange="showIMG(this)" class="form-control" type="file">
                            <script>
                                function showIMG(file) {
                                    $("#showIMG2").attr('src', file.value);
                                    if (file.files && file.files[0]) {

                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            $('#showIMG2').attr('src', e.target.result);
                                        }

                                        reader.readAsDataURL(file.files[0]);
                                    }
                                }
                            </script>
                            <img id="showIMG2" style="width: 100px;" class="d-flex mx-auto mt-3">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">ที่อยู่</label>
                            <textarea id="address2" rows="1" class="form-control"></textarea>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">วันเกิด</label>
                            <input id="birthday2" class="form-control" type="text">
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger">ล้าง</button>
                <button id="btn-supplier" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<script>
    // hidden manage button
    $('#cc-checkbox').click((e) => $('.cc-manage').toggleClass("d-none"))

    // search
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

    // search reset
    $('#btn-reset').click(() => {
        $('#search-table').val('')
        search_table('')
    })

    // add supplier
    $('#btn-sup').click(() => {
        const data = new FormData()
        data.append('form_sup', 'addsup')
        data.append('id', $('#member-id').val())
        data.append('name', $('#name').val())
        data.append('vat', $('#vat-num').val())
        data.append('file', $('#file')[0].files[0])
        data.append('address', $('#address').val())
        data.append('phone', $('#phone').val())
        data.append('birthday', $('#birthday').val())
        
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                res == 1 ? swalsuccess() : swalerror()
                setTimeout(() => location.reload(), 1200)
            }
        });
    }) 
    
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

    // get data
    function getdata(id) {
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType:'json',
            data: {
                id: id,
                getsup: 1
            },
            success: (res) => {
                $('#modal3').modal('show')
                $('#input-id2').val(res.sup_id)
                $('#member-id2').val(res.sup_member_id)
                $('#name2').val(res.sup_name)
                $('#vat-num2').val(res.sup_vat_number)
                $('#phone2').val(res.sup_phone)
                $('#showIMG2').attr('src',`controller/img/${res.sup_img}`)
                $('#address2').text(res.sup_address)
                $('#birthday2').val(res.sup_birthday)
            }
        });
    } 

    // update supplier
    $('#btn-supplier').click(() => {
        const data = new FormData();
        data.append('form_supplier', 'updatesup')
        data.append('id', $('#input-id2').val())
        data.append('member_id', $('#member-id2').val())
        data.append('name', $('#name2').val())
        data.append('vat', $('#vat-num2').val())
        data.append('address', $('#address2').val())
        data.append('phone', $('#phone2').val())
        data.append('birthday', $('#birthday2').val())
        data.append('file', $('#file2')[0].files[0])

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                $('#modal3').modal('hide')
                if(res == 1) swalsuccess()
                setTimeout(() => location.reload(), 1200)
            }
        });
        
    })

    const delsup = (id) => {
        const data = new FormData();
        data.append('form_supplier', 'delsup')
        data.append('id', id)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                res == 1 ? swalsuccess() : swalerror()
                setTimeout(() => location.reload(), 1200)
            }
        });
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
                delsup(id)
            }
        })
    }



</script>